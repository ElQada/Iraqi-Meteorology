class ElqadaDataTables {
    static config = {
        defaultFonts: {
            Amiri: {
                normal: 'fonts/Amiri-Regular.ttf',
                bold: 'fonts/Amiri-Bold.ttf',
                italics: 'fonts/Amiri-Italic.ttf',
                bolditalics: 'fonts/Amiri-BoldItalic.ttf'
            }
        },
        defaultPageSettings: {
            sizes: ['portrait', 'landscape', 'A4', 'A3', {width: 2500, height: 800}],
            orders: [[1, 'asc'], [0, 'desc']],
            defaultSize: 'A4',
            defaultOrientation: 'landscape',
            defaultOrder: [1, 'asc']
        },
        defaultExportSettings: {
            filenamePrefix: () => `${document.title.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0,10)}`,
            pdfStyles: {
                title: { fontSize: 12, bold: true, alignment: 'center', margin: [1, 1, 1, 3] },
                column: { fontSize: 10, alignment: 'center', color: '#0c5700', margin: [1, 1, 1, 1] },
                key: { fontSize: 9, bold: true, color: '#0b0684', alignment: 'center', margin: [0, 0, 0, 0] },
                value: { bold: true, fontSize: 8, color: '#000000', alignment: 'center', margin: [1, 1, 1, 1] },
                error: { bold: true, fontSize: 10, color: '#FF0000', alignment: 'center', margin: [0, 0, 0, 0] }
            }
        }
    };

    constructor(options = {}) {
        this.id = options.id || `elqada-datatable-${Date.now()}`;
        this.element = options.element || this.id;
        this.name = options.name || 'Elqada Data Table';
        this.data = options.data || [];
        this.keys = options.keys || this.detectKeys();
        this.renameMap = options.renameMap || {};
        this.inputs = options.inputs || {};
        this.fonts = options.fonts || ElqadaDataTables.config.defaultFonts;
        this.pageSettings = { ...ElqadaDataTables.config.defaultPageSettings, ...options.pageSettings };
        this.canDownload = options.canDownload !== false;
        this.reportConfig = options.reportConfig || {};
        this.keyValueFormat = options.keyValueFormat || false;
        this.buttons = options.buttons || this.defaultButtons();
        this.lengthMenu = options.lengthMenu || this.createLengthMenu();
        this.isRTL = document.dir === 'rtl';

        this.callbacks = {
            createdRow: options.createdRow || this.defaultCreatedRow,
            initComplete: options.initComplete || this.defaultInitComplete,
            pdfRow: options.pdfRow || this.defaultPdfRow,
            formatData: options.formatData || this.defaultFormatData,
            afterRender: options.afterRender || this.defaultAfterRender,
            onChange: options.onChange || this.defaultOnChange
        };

        this.history = {};
        this.instances = {};

        this.init();
    }

    // Initialization methods
    init() {
        this.registerFonts();
        this.prepareData();
        this.createTableInstance();
    }

    registerFonts() {
        if (typeof pdfMake !== 'undefined') {
            pdfMake.fonts = this.fonts;
        }
    }

    prepareData() {
        this.processedData = this.data.map(row => {
            const processedRow = {};
            this.keys.forEach(key => {
                processedRow[key] = row[key] !== null ? row[key].toString() : '';
            });
            return processedRow;
        });
    }

    createTableInstance() {
        const tableElement = document.getElementById(this.element);
        if (!tableElement) {
            console.error(`Element with ID ${this.element} not found`);
            return;
        }

        tableElement.style.display = 'none';
        const waitElement = document.getElementById(`${this.element}-wait`);
        if (waitElement) waitElement.style.display = 'block';

        this.generateTableHeader();
        this.renderTable();

        if (typeof $ !== 'undefined') {
            this.dataTableInstance = $(`#${this.id}`).DataTable(this.getDataTableConfig());
            this.setupEventListeners();
        }
    }

    // Core functionality methods
    detectKeys() {
        if (this.data.length > 0) {
            return Object.keys(this.data[0]);
        }
        return ['...'];
    }

    generateTableHeader() {
        this.headerHTML = this.keys.map((key, index) => {
            const displayName = this.renameMap[key] || key;
            const isHidden = key.includes('...') ? '_X_' : '';
            return key !== '...'
                ? `<th class="${isHidden}">${displayName}<br>
           <input type="text" placeholder="" name="${this.id}-${key}" 
           id="${this.id}-${key}" value="" class="Search" data-index="${index}"/></th>`
                : '';
        }).join('');
    }

    renderTable() {
        const tableContainer = document.getElementById(this.element);
        if (tableContainer) {
            tableContainer.innerHTML = `
        <table style="direction: ltr;" id="${this.id}" 
               data-id="${this.id}" class="table table-striped table-bordered">
          <thead><tr>${this.headerHTML}</tr></thead>
          <tbody></tbody>
          <tfoot></tfoot>
        </table>`;
        }
    }

    getDataTableConfig() {
        return {
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-6 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            order: this.data.length ? this.pageSettings.defaultOrder : false,
            columns: this.keys.map(key => ({ data: key })),
            language: {
                paginate: {
                    next: '<i class="fas fa-angle-double-right"></i>',
                    previous: '<i class="fas fa-angle-double-left"></i>',
                    first: '<i class="fad fa-angle-double-right"></i>',
                    last: '<i class="fad fa-angle-double-left"></i>'
                }
            },
            columnDefs: [{
                targets: -1,
                orderable: false,
                render: (data, type, full, meta) => this.renderActionButtons(data, type, full, meta)
            }],
            paging: Object.values(this.lengthMenu).length > 1,
            lengthMenu: [Object.values(this.lengthMenu), Object.keys(this.lengthMenu)],
            autoWidth: true,
            lengthChange: Object.values(this.lengthMenu).length > 1,
            data: this.callbacks.onChange(this.processedData),
            buttons: Object.values(this.buttons),
            createdRow: (row, data, index) => this.handleRowCreation(row, data, index),
            initComplete: (settings, json) => this.callbacks.initComplete(settings, json)
        };
    }

    // UI Rendering methods
    renderActionButtons(data, type, full, meta) {
        if (parseInt(data) == data && this.keys.includes('id')) {
            return `
        <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit">
          <input type="checkbox" value="${data}" data-id="${data}" 
                 onchange="elqada.DataTables.instances['${this.id}'].selectRow(this)" 
                 class="dt-checkboxes form-check-input">${data}
        </button>
        <div class="d-inline-block">
          <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" 
                  data-bs-toggle="dropdown">
            <i class="ti ti-dots-vertical ti-md _event_" title="More.."></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end m-0">
            <li>
              <button data-id="${data}" 
                      onclick="elqada.DataTables.instances['${this.id}'].showDetails('${data}')" 
                      class="dropdown-item" style="justify-content: center;">
                <i class="fas fa-scroll _event_" title="Details.."></i> 
                ${this.renameMap['Details'] || 'Details'}
              </button>
            </li>
            <div class="dropdown-divider"></div>
            <li>
              <button class="dropdown-item text-danger delete-record" 
                      style="justify-content: center;" 
                      data-id="${data}" 
                      onclick="elqada.DataTables.instances['${this.id}'].deleteRow('${data}')">
                <i class="far fa-trash-alt _event_" title="Delete.."></i> 
                ${this.renameMap['Delete'] || 'Delete'}
              </button>
            </li>
          </ul>
        </div>
        <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit" 
                data-id="${data}" 
                onclick="elqada.DataTables.instances['${this.id}'].editRow('${data}')">
          <i class="ti ti-pencil ti-md _event_" title="Edit.."></i>
        </button>`;
        }
        return data;
    }

    // Event handling methods
    setupEventListeners() {
        document.querySelectorAll(`#${this.id} thead input`).forEach(input => {
            input.addEventListener('keyup', () => this.searchColumn(input));
            input.addEventListener('search', () => this.searchColumn(input));
            input.addEventListener('change', () => this.searchColumn(input));
        });

        Object.keys(this.inputs).forEach(key => {
            const columnIndex = this.keys.indexOf(key.replace(`${this.id}-`, ''));
            if (columnIndex > -1) {
                this.searchColumn({
                    getAttribute: () => columnIndex,
                    value: this.inputs[key]
                });
            }
        });

        setTimeout(() => {
            const tableElement = document.getElementById(this.element);
            if (tableElement) tableElement.style.display = 'block';

            const waitElement = document.getElementById(`${this.element}-wait`);
            if (waitElement) waitElement.style.display = 'none';

            this.callbacks.afterRender();
        }, 125 + Math.round(this.data.length / 125));
    }

    searchColumn(inputElement) {
        const columnIndex = parseInt(inputElement.getAttribute('data-index'));
        const searchValue = inputElement.value;

        if (this.keys.hasOwnProperty(columnIndex)) {
            const key = `${this.id}-${this.keys[columnIndex]}`;
            this.inputs[key] = searchValue;
            this.dataTableInstance.column(columnIndex).search(searchValue, true, false).draw();
        }
    }

    // Data manipulation methods
    findIndex(id) {
        return this.data.findIndex(item => item.id.toString() === id.toString());
    }

    deleteRow(id) {
        const index = this.findIndex(id);
        if (index > -1) {
            this.data.splice(index, 1);
            this.refresh();
        }
    }

    getRowData(id) {
        const index = this.findIndex(id);
        if (index > -1) {
            const rowData = { ...this.data[index] };
            Object.keys(this.data[index]).forEach(key => {
                rowData[`_${key}`] = this.data[index][key];
            });
            return rowData;
        }
        return {};
    }

    addRow(rowData) {
        this.data.push(rowData);
        this.refresh();
    }

    updateRow(id, newData) {
        const index = this.findIndex(id);
        if (index > -1) {
            this.data[index] = { ...this.data[index], ...newData };
            this.refresh();
        }
    }

    refresh() {
        if (this.dataTableInstance) {
            this.prepareData();
            this.dataTableInstance.clear();
            this.dataTableInstance.rows.add(this.callbacks.onChange(this.processedData));
            this.dataTableInstance.draw();
        }
    }

    // Export methods
    exportToPDF() {
        if (!this.canDownload || typeof pdfMake === 'undefined') return;

        const tableBody = this.generatePdfBody();
        const docDefinition = this.createPdfDocument(tableBody);

        pdfMake.createPdf(docDefinition).download(
            `${this.name.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0,10)}.pdf`
        );
    }

    generatePdfBody() {
        return this.data.map(record => {
            const row = [];
            const errors = this.extractErrorFields(record);

            Object.keys(this.reportConfig).forEach(column => {
                const dataColumn = [];
                if (!column.includes('_X_')) {
                    dataColumn.push({ text: column, style: 'column' });
                }

                this.reportConfig[column].forEach(key => {
                    const value = record[key] !== null && record[key] !== undefined ? record[key] : '';
                    const displayKey = this.renameMap[key] || key;

                    if (this.keyValueFormat) {
                        dataColumn.push({ text: displayKey, style: 'key' });
                        dataColumn.push({
                            text: value,
                            style: errors.includes(key) ? 'error' : 'value'
                        });
                    } else {
                        dataColumn.push({
                            text: `${displayKey} : ${value}`,
                            style: errors.includes(key) ? 'error' : 'value'
                        });
                    }
                });

                row.push(dataColumn);
            });

            return row;
        });
    }

    extractErrorFields(record) {
        if (typeof record['_E_'] === 'string' && record['_E_'].includes('@')) {
            return record['_E_']
                .replaceAll('  -  ', '-')
                .replace(' [ ', '')
                .replace(' ] ', '')
                .split('@')[1]
                .split('-');
        }
        return [];
    }

    createPdfDocument(body) {
        return {
            pageSize: this.pageSettings.defaultSize,
            pageOrientation: this.pageSettings.defaultOrientation,
            pageMargins: [5, 5, 5, 5],
            content: [
                {
                    text: `${this.name.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0,10)}`,
                    style: "title"
                },
                {
                    table: {
                        widths: Array(Object.keys(this.reportConfig).length)
                            .fill(`${(100 / Object.keys(this.reportConfig).length - 0.05)}%`),
                        body
                    },
                    layout: {
                        fillColor: rowIndex => rowIndex % 2 === 0 ? '#f9f9f9' : null
                    }
                }
            ],
            styles: ElqadaDataTables.config.defaultExportSettings.pdfStyles,
            defaultStyle: { font: "Amiri" }
        };
    }

    // Default callbacks
    defaultCreatedRow(row, data, index) {
        const errors = this.extractErrorFields(this.data[index]);
        const hasTotal = row.cells.item(0).innerText.includes('@');

        for (let i = 0; i < row.childElementCount; i++) {
            const key = this.keys[i];
            const displayName = this.renameMap[key] || key;

            row.cells.item(i).title = displayName;

            if (errors.includes(key)) {
                row.cells.item(i).style.backgroundColor = '#e13232';
            }
            if (hasTotal) {
                row.cells.item(i).style.backgroundColor = "#7dc2e4";
            }
        }

        if (errors.length) {
            row.cells.item(0).style.backgroundColor = '#e13232';
        }
    }

    defaultInitComplete(settings, json) {
        console.log('Table initialization complete', settings, json);
    }

    defaultPdfRow(row, rowIndex, data) {
        // Custom PDF row formatting can be added here
    }

    defaultFormatData(data) {
        return data.data;
    }

    defaultAfterRender() {
        console.log('Table rendering complete');
    }

    defaultOnChange(data) {
        return data;
    }

    // Utility methods
    createLengthMenu() {
        return {
            '10': 10,
            '25': 25,
            '50': 50,
            '100': 100,
            'All': -1
        };
    }

    defaultButtons() {
        return {
            select: {
                extend: 'colvis',
                className: "btn-light",
                text: this.renameMap['Select View'] || 'Select View',
                attr: { id: `${this.id}-Select` }
            },
            reselect: {
                extend: 'colvisRestore',
                text: this.renameMap['View All'] || 'View All',
                className: "btn-success",
                attr: { id: `${this.id}-Reselect` }
            },
            excel: this.createExportButton('excel', 'Excel', 'btn-info'),
            pdf: this.createExportButton('pdf', 'PDF', 'btn-danger'),
            print: this.createExportButton('print', 'Print', 'btn-success'),
            csv: this.createExportButton('csv', 'CSV', 'btn-warning'),
            copy: this.createExportButton('copy', 'Copy', 'btn-dark'),
            report: {
                text: this.renameMap['Report'] || 'Report',
                className: "btn-dark",
                action: () => this.exportToPDF(),
                attr: { id: `${this.id}-Report` }
            },
            add: {
                text: this.renameMap['Add'] || 'Add',
                className: 'create-new btn btn-primary waves-effect waves-light',
                action: () => this.addNewRow(),
                attr: { id: `${this.id}-New` }
            },
            edit: {
                text: this.renameMap['Edit'] || 'Edit',
                className: 'create-new btn btn-orange waves-effect waves-light',
                action: (e, dt, button, config) => this.editSelectedRow(),
                attr: { id: `${this.id}-Edit` }
            }
        };
    }

    createExportButton(type, text, className) {
        return {
            extend: `${type}Html5`,
            text: this.renameMap[text] || text,
            className,
            exportOptions: {
                orthogonal: "export",
                columns: ':visible:not(._X_)',
                modifier: { search: 'applied', order: 'applied' },
                format: {
                    body: (data, row, column, node) => this.callbacks.formatData({ data, row, column, node }, type)
                }
            },
            title: `${this.name.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0,10)}`,
            ...(type === 'pdf' ? {
                orientation: this.pageSettings.defaultOrientation,
                pageSize: this.pageSettings.defaultSize,
                customize: doc => this.customizePdfExport(doc)
            } : {}),
            attr: { id: `${this.id}-${text}` }
        };
    }

    customizePdfExport(doc) {
        doc.pageMargins = 6;
        const layout = {
            hLineWidth: i => 0.1,
            vLineWidth: i => 0.1,
            hLineColor: i => '#000000',
            vLineColor: i => '#000000'
        };

        if (doc.content[1]) {
            doc.content[1].layout = layout;
        }

        const arabicRegex = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF]/;

        if (doc.content[1] && doc.content[1].table) {
            doc.content[1].table.body.forEach((row, rowIndex) => {
                const hasTotal = row[0] && row[0].text && row[0].text.toString().includes('@');
                const errors = rowIndex > 0 ? this.extractErrorFields(this.data[rowIndex - 1]) : [];

                row.forEach((cell, cellIndex) => {
                    if (cell && cell.text) {
                        if (arabicRegex.test(cell.text)) {
                            cell.text = cell.text.split(' ').reverse().join(' ');
                        }

                        if (rowIndex === 0) {
                            cell.fillColor = "#007bff";
                        } else if (hasTotal) {
                            cell.fillColor = "#7dc2e4";
                        } else if (rowIndex % 2) {
                            cell.fillColor = "#ffffff";
                        } else {
                            cell.fillColor = "#cbcbcb";
                        }

                        if (errors.includes(this.keys[cellIndex])) {
                            cell.fillColor = "#e13232";
                        }
                    }
                });

                this.callbacks.pdfRow(row, rowIndex, doc.content[1].table.body);
            });
        }
    }

    // Modal methods
    showDetails(id, footerText = "Eng / Samer Shuaa © 2025") {
        const index = this.findIndex(id);
        if (index > -1) {
            this.showModal('', this.data[index], footerText);
        }
    }

    showModal(title, data, footerText = 'Eng / Samer Shuaa © 2025', isSubTable = false) {
        const modalId = `${this.id}${isSubTable ? '_SubTable' : ''}-Data-Table-View`;
        const modal = new bootstrap.Modal(document.getElementById(modalId));

        if (data) {
            document.getElementById(`${modalId}-Title`).textContent = document.title;
            document.getElementById(`${modalId}-Body`).innerHTML = this.generateModalBody(data, isSubTable);
            document.getElementById(`${modalId}-Footer`).innerHTML = `
        <i class="fa-solid fa-print _event_" title="Print" 
           onclick="elqada.DataTables.instances['${this.id}'].printModal('${modalId}-Body')"></i>
        ${footerText}
      `;
        }

        modal.show();
    }

    generateModalBody(data, isSubTable) {
        if (isSubTable) {
            return `<div class="table-responsive">
        <table class="table datatables-basic">
          <tbody>
            ${Object.keys(data).map((key, index) => `
              <tr data-dt-row="99" data-dt-column="${index}">
                ${this.generateModalRowContent(key, data[key])}
              </tr>
            `).reverse().join('')}
          </tbody>
        </table>
      </div>`;
        }

        return `<div class="MainTable">
      <div class="DataTableTitle">${this.name}</div>
      <div>
        <div id="${this.id}-Data-Table-Control">
          <!-- Control elements would go here -->
        </div>
        <div id="${this.id}-Data-Table" class="Data-Table">
          <div class="Title" style="width: 100%">No data to display</div>
        </div>
      </div>
    </div>`;
    }

    generateModalRowContent(key, value) {
        if (Array.isArray(value)) {
            return value.map(subData => `
        ${Object.keys(subData).map((subKey, subIndex) => `
          <td> : ${this.renameMap[subKey] || subKey}  </td>
          <td data-dt--sub-column="${subIndex}"> ${subData[subKey]} </td>
        `).reverse().join('')}
      `).join('');
        }

        if (typeof value === 'object' && value !== null) {
            return Object.keys(value).map((subKey, subIndex) => `
        <td> : ${this.renameMap[subKey] || subKey} </td>
        <td data-dt--sub-column="${subIndex}"> ${value[subKey]} </td>
      `).reverse().join('');
        }

        return `
      <td> : ${this.renameMap[key] || key} </td>
      <td> ${value} </td>
    `;
    }

    printModal(elementId) {
        const printContent = document.getElementById(elementId).innerHTML;
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        this.refresh();
    }

    // Public API
    static create(options) {
        const instance = new ElqadaDataTables(options);
        this.instances[instance.id] = instance;
        return instance;
    }

    static getInstance(id) {
        return this.instances[id];
    }
}

// Initialize as global if needed
if (typeof elqada === 'undefined') {
    window.elqada = {};
}
elqada.DataTables = ElqadaDataTables;

elqada.DataTables.create();
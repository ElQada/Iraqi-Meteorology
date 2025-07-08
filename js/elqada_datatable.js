var ElqadaDataTable = {}; ElqadaDataTable = {
    $ID : null,
    ID : function ($ID = null)
    {
        if ($ID === null)
        {
            $ID = 'ElqadaDataTable';
        }
        this.$ID = $ID;
        return this;
    },
    $Element : null,
    Element : function ($Element = null)
    {
        if ($Element === null)
        {
            $Element = 'Elqada-DataTable';
        }
        this.$Element = $Element;
        return this;
    },
    $Name : null,
    Name : function ($Name = null)
    {
        if ($Name === null)
        {
            $Name = 'Elqada-Data-Table';
        }
        this.$Name = $Name;
        return this;
    },
    $Rename : null,
    Rename : function ($Rename = null)
    {
        if ($Rename === null)
        {
            $Rename = {};
        }
        this.$Rename = $Rename;
        return this;
    },
    $Length : null,
    Length : function ($Length = null)
    {
        if ($Length === null)
        {
            $Length = {};
        }
        this.$Length = $Length;
        return this;
    },
    $Keys : null,
    Keys : function ($Keys = null)
    {
        if ($Keys === null)
        {
            if (ElqadaDataTable.$Data instanceof Array && ElqadaDataTable.$Data.length)
            {
                $Keys = Object.keys(ElqadaDataTable.$Data[0]);
            }
            else
            {
                $Keys = [];
            }
        }
        this.$Keys = $Keys;
        return this;
    },
    $Inputs : null,
    Inputs : function ($Inputs = null)
    {
        if ($Inputs === null)
        {
            $Inputs = {};
        }
        this.$Inputs = $Inputs;
        return this;
    },
    $Data : null,
    Data : function ($Data = null)
    {
        if ($Data === null)
        {
            $Data = [];
        }
        this.$Data = $Data;
        return this;
    },
    $Fonts : null,
    Fonts : function ($Fonts = null)
    {
        if ($Fonts === null)
        {
            $Fonts = {
                Amiri: {
                    normal: CurrentLink + '/fonts/Amiri-Regular.ttf',
                    bold: CurrentLink + '/fonts/Amiri-Bold.ttf',
                    italics: CurrentLink + '/fonts/Amiri-Italic.ttf',
                    bolditalics: CurrentLink + '/fonts/Amiri-BoldItalic.ttf'
                }
            };
        }
        this.$Fonts = $Fonts;
        return this;
    },
    $Page : {
        Values : ['portrait','landscape','A4','A3',{ width: 2500, height: 800 },[1, 'asc'],[0, 'desc']],
        Size : 'A4',
        Orientation : 'landscape',
        Order : [1, 'asc'],
    },
    $CanDownload : null,
    CanDownload : function ($CanDownload = null)
    {
        if ($CanDownload === null)
        {
            $CanDownload = true;
        }
        this.$CanDownload = $CanDownload;
        return this;
    },
    $Report : null,
    Report : function ($Report = null)
    {
        if ($Report === null)
        {
            $Report = {};
        }
        this.$Report = $Report;
        return this;
    },
    $KeyValue : null,
    KeyValue : function ($KeyValue = null)
    {
        if ($KeyValue === null)
        {
            $KeyValue = false;
        }
        this.$KeyValue = $KeyValue;
        return this;
    },
    $Buttons$ :  {},
    $Buttons : {},
    $Tables : {},
    Optimize : function ()
    {
        ElqadaDataTable.CreatedRow = function ($Row,$Data,$Index) {};
        ElqadaDataTable.InitComplete = function (Settings, Json){};
        ElqadaDataTable.PDFRow = function (Row,Index,Data) {};
        ElqadaDataTable.After = function () {};
        ElqadaDataTable.$Page = {
            Values : ['portrait','landscape','A4','A3',{ width: 2500, height: 800 },[1, 'asc'],[0, 'desc']],
            Size : 'A4',
            Orientation : 'landscape',
            Order : [1, 'asc'],
        };
    },
    CreatedRow : function ($Row,$Data,$Index)
    {

    },
    InitComplete : function (Settings, Json){

    },
    PDFRow : function (Row,Index,Data)
    {

    },
    After : function ()
    {

    },
    Set : function ($Buttons = null,$ID = null)
    {
        ['ID','Element','Name','Keys','Rename','Inputs','Fonts','Data','CanDownload','Report','Length','KeyValue'].forEach((Key)=>{
            if (ElqadaDataTable['$'+Key] === null)
            {
                ElqadaDataTable[Key]();
            }
        });
        /* ---------------------------------------=[|=>|]  [|<=|]=----------------------------------------------- */
        if ($ID === null)
        {
            $ID = ElqadaDataTable.$ID;
        }
        /* ---------------------------------------=[|=>|]  [|<=|]=----------------------------------------------- */
        let $Date = '',Current$Date = "_At_"+(new Date()).toISOString().slice(0,10)+"_T_"+(new Date()).toTimeString().slice(0,8)+"_)", $Station = PHP.Sesstion.StationName;
        if (!GetElementValue('SetYear'))
        {
            if (GetElementValue('_date_'))
            {
                $Date = ("(_From_"+GetElementValue('date')+"_To_"+GetElementValue('_date_')+Current$Date);
            }
            else
            {
                $Date = ("(_From_"+GetElementValue('date')+"_To_"+PHP.MaxDate+Current$Date);
            }
        }
        else
        {
            $Date = ("(_From_"+GetElementValue('SetYear')+"_"+GetElementValue('SetMonthFrom')+"_To_"+GetElementValue('SetYear')+"_"+GetElementValue('SetMonthTo')+Current$Date);
        }
        if (StringIsArabic($Station))
        {
            $Station = "All_Stations";
        }
        $Date = $Date.replaceAll(':','-').replaceAll('/','_')+"_"+$Station+"_";
        /* ---------------------------------------=[|=>|]  [|<=|]=----------------------------------------------- */
        ElqadaDataTable.$Tables[$ID] =
            {
                $ID : $ID,
                $Date : $Date,
                $Element : ElqadaDataTable.$Element,
                $Name : ElqadaDataTable.$Name,
                $Keys : ElqadaDataTable.$Keys,
                $Rename : ElqadaDataTable.$Rename,
                $Inputs : ElqadaDataTable.$Inputs,
                $Fonts : ElqadaDataTable.$Fonts,
                $Data : ElqadaDataTable.$Data,
                $CanDownload : ElqadaDataTable.$CanDownload,
                $Report : ElqadaDataTable.$Report,
                $Length : ElqadaDataTable.$Length,
                $Page : ElqadaDataTable.$Page,
                $KeyValue : ElqadaDataTable.$KeyValue,
                CreatedRow : ElqadaDataTable.CreatedRow,
                InitComplete: ElqadaDataTable.InitComplete,
                After: ElqadaDataTable.After,
                PDFRow : ElqadaDataTable.PDFRow,
                $Buttons : [],
                Download : false,
                Header : '',
                Data : [],
                Table: {},
                Clear: function () {
                    ElqadaDataTable.$Tables[$ID].$Keys.forEach((Key, Index) =>
                    {
                        ElqadaDataTable.$Tables[$ID].Search(Index, '');
                    });
                },
                Search: function (Index, Value) {
                    if (ElqadaDataTable.$Tables[$ID].$Keys.hasOwnProperty(Index)) {
                        let Key = ElqadaDataTable.$Tables[$ID].$ID+'-'+ElqadaDataTable.$Tables[$ID].$Keys[Index];
                        document.getElementById(Key).value = Value;
                        ElqadaDataTable.$Tables[$ID].$Inputs[Key] = Value;
                        ElqadaDataTable.$Tables[$ID].Table.column(Index).search(Value).draw();
                    }
                },
                Install: function ($ID = null) {
                    if ($ID === null)
                    {
                        $ID = ElqadaDataTable.$ID;
                    }
                    /* -----------------------------------=[|=>|]  [|<=|]=--------------------------------------- */
                    document.getElementById(ElqadaDataTable.$Tables[$ID].$Element).style.display = 'none';
                    document.getElementById(ElqadaDataTable.$Tables[$ID].$Element+'-Wait').style.display = 'block';
                    /* -----------------------------------=[|=>|]  [|<=|]=--------------------------------------- */
                    pdfMake.fonts = ElqadaDataTable.$Tables[$ID].$Fonts;
                    /* -----------------------------------=[|=>|]  [|<=|]=--------------------------------------- */
                    ElqadaDataTable.$Tables[$ID].$Data.forEach((Row) => {
                        let $Row = [];
                        ElqadaDataTable.$Tables[$ID].$Keys.forEach(($K0) => {
                            if (Row.hasOwnProperty($K0) && Row[$K0] != null) {
                                $Row.push(Row[$K0].toString());
                            } else {
                                $Row.push('');
                            }
                        });
                        ElqadaDataTable.$Tables[$ID].Data.push($Row);
                    });
                    /* --------------------------=[|=>|]  [|<=|]=-------------------------- */
                    ElqadaDataTable.$Tables[$ID].Header = '';
                    ElqadaDataTable.$Tables[$ID].$Keys.forEach(($K,$I) => {
                        let Key = $ID+'-'+$K;
                        if (ElqadaDataTable.$Tables[$ID].$Rename.hasOwnProperty($K))
                        {
                            $K = ElqadaDataTable.$Tables[$ID].$Rename[$K];
                        }
                        ElqadaDataTable.$Tables[$ID].Header += `<th>${$K}<hr><input type="text" placeholder="" name="${Key}" id="${Key}" value="" class="Search" data-index="${$I}"/></th>`;
                    });
                    /* --------------------------=[|=>|]  [|<=|]=-------------------------- */
                    window.addEventListener('DOMContentLoaded', () => {
                        document.getElementById(ElqadaDataTable.$Tables[$ID].$Element).innerHTML = `<table id="${ElqadaDataTable.$Tables[$ID].$ID}" data-id="${ElqadaDataTable.$Tables[$ID].$ID}" class="table table-striped table-bordered"><thead><tr>${ElqadaDataTable.$Tables[$ID].Header}</tr></thead><tbody></tbody><tfoot></tfoot></table>`;
                        setTimeout(()=>{
                            ElqadaDataTable.$Tables[$ID].Table = $("#"+ElqadaDataTable.$Tables[$ID].$ID).DataTable({
                                "dom": '<"dt-buttons"Bf><"clear">lirtp',
                                order: ElqadaDataTable.$Tables[$ID].$Page.Order,
                                paging: (Object.values(ElqadaDataTable.$Tables[$ID].$Length).length>1),
                                lengthMenu: [Object.values(ElqadaDataTable.$Tables[$ID].$Length),Object.keys(ElqadaDataTable.$Tables[$ID].$Length)],
                                autoWidth: true,
                                lengthChange: (Object.values(ElqadaDataTable.$Tables[$ID].$Length).length>1),
                                data: ElqadaDataTable.$Tables[$ID].Data,
                                buttons: Object.values(ElqadaDataTable.$Tables[$ID].$Buttons),
                                createdRow: function (Row, Data, Index) {
                                    let HasErrors  = [];
                                    let HasTotal = Row.cells.item(0).innerText.includes('@');

                                    ElqadaDataTable.$Tables[$ID].CreatedRow(Row, Data, Index);

                                    if (ElqadaDataTable.$Tables[$ID].$Data[Index].hasOwnProperty('Error') && ElqadaDataTable.$Tables[$ID].$Data[Index]['Error'].includes('@')) {
                                        ElqadaDataTable.$Tables[$ID].$Data[Index]['Error'].replaceAll('  -  ', '-').replace(' [ ', '').replace(' ] ', '').split('@')[1].split('-').forEach((Key) => {
                                            HasErrors.push(ElqadaDataTable.$Tables[$ID].$Keys.indexOf(Key));
                                            Row.cells.item(0).style.backgroundColor = '#e13232';
                                        });
                                    }

                                    for (let I = 0; I < Row.childElementCount; I++) {
                                        let Key = ElqadaDataTable.$Tables[$ID].$Keys[I];
                                        if (ElqadaDataTable.$Tables[$ID].$Rename.hasOwnProperty(Key))
                                        {
                                            Key = ElqadaDataTable.$Tables[$ID].$Rename[Key];
                                        }
                                        Row.cells.item(I).title = Key;
                                        if (HasErrors.includes(I))
                                        {
                                            Row.cells.item(I).style.backgroundColor = '#e13232';
                                        }
                                        if (HasTotal)
                                        {
                                            Row.cells.item(I).style.backgroundColor = "#7dc2e4";
                                        }
                                    }

                                },
                                initComplete: (settings, json) => {
                                    ElqadaDataTable.$Tables[$ID].InitComplete(settings,json);
                                }
                            });
                            setTimeout(()=>{
                                document.querySelectorAll("#"+ElqadaDataTable.$Tables[$ID].$ID+" thead input").forEach((Element)=>{
                                    Element.addEventListener('keyup',()=>{ElqadaDataTable.$Tables[$ID].Search(Element.getAttribute('data-index'), Element.value)});
                                    Element.addEventListener('search',()=>{ElqadaDataTable.$Tables[$ID].Search(Element.getAttribute('data-index'), Element.value)});
                                    Element.addEventListener('change',()=>{ElqadaDataTable.$Tables[$ID].Search(Element.getAttribute('data-index'), Element.value)});
                                });
                                Object.keys(ElqadaDataTable.$Tables[$ID].$Inputs).forEach((K) => {
                                    ElqadaDataTable.$Tables[$ID].Search(ElqadaDataTable.$Tables[$ID].$Keys.indexOf(K), ElqadaDataTable.$Tables[$ID].$Inputs[K]);
                                });
                                ElqadaDataTable.$Tables[$ID].After();
                            },(125+Math.round(ElqadaDataTable.$Data.length/125)));
                            document.getElementById(ElqadaDataTable.$Tables[$ID].$Element).style.display = 'block';
                            document.getElementById(ElqadaDataTable.$Tables[$ID].$Element+'-Wait').style.display = 'none';
                        },(125+Math.round(ElqadaDataTable.$Data.length/125)));
                    });
                }
            };
        /* ---------------------------------------=[|=>|]  [|<=|]=----------------------------------------------- */
        ElqadaDataTable.$Buttons$ = {
            'Select' : {extend: 'colvis', className: "btn-light", text: 'Select View'},
            'Reselect' : {extend: 'colvisRestore', text: 'View All', className: "btn-success"},
            'Excel' : {
                extend: 'excelHtml5',
                text: 'Excel',
                className: "btn-info",
                autoFilter: true,
                exportOptions: {
                    orthogonal: "arabicPDF",
                    columns: ':visible',
                    modifier: {search: 'applied', order: 'applied'}
                },
                title : ((ElqadaDataTable.$Tables[$ID].$Name).split(' ').join('_'))+"_"+ElqadaDataTable.$Tables[$ID].$Date,
                sheetName: ((ElqadaDataTable.$Tables[$ID].$Name).split(' ').join('_'))+"_"+ElqadaDataTable.$Tables[$ID].$Date,
                filename: ((ElqadaDataTable.$Tables[$ID].$Name).split(' ').join('_'))+"_"+ElqadaDataTable.$Tables[$ID].$Date,
                messageTop : ((ElqadaDataTable.$Tables[$ID].$Name).split(' ').join('_'))+"_"+ElqadaDataTable.$Tables[$ID].$Date,
                customize: function (xlsx)
                {
                    var sheet = xlsx.xl.worksheets[ElqadaDataTable.$Tables[$ID].$Name+'.xml'];
                    $('col', sheet).attr('width', 20);
                    $('c', sheet).attr('s', '51');
                }
            },
            'Report' :{
                text: 'Report',
                className: "btn-dark",
                exportOptions: {
                    orthogonal: "arabicPDF",
                    columns: ':visible',
                    modifier: {search: 'applied', order: 'applied'}
                },
                autoFilter: true,
                action: function (e, dt, node, config) {
                    node[0].innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                    node[0].disabled = true;
                    ElqadaDataTable.$Tables[$ID].Download = true;
                    if (ElqadaDataTable.$Tables[$ID].Download) {
                        ElqadaDataTable.$Tables[$ID].$CanDownload = false;
                        let TableBody = [];
                        ElqadaDataTable.$Tables[$ID].$Data.forEach(Record => {
                            let Row = [];
                            let Errors = [];
                            if (typeof Record['Error'] == 'string' && Record['Error'].includes('@')) {
                                Errors = Record['Error'].replaceAll('  -  ', '-').replace(' [ ', '').replace(' ] ', '').split('@')[1].split('-');
                            }
                            Object.keys(ElqadaDataTable.$Tables[$ID].$Report).forEach((Column) => {
                                let DataColumn = [];
                                if (!Column.includes('$G@'))
                                {
                                    DataColumn.push({ text: Column, style: 'Column' });
                                }
                                ElqadaDataTable.$Tables[$ID].$Report[Column].forEach((Key) =>
                                {
                                    let Set = '',$Key = Key;
                                    if (Record[Key] !== null && Record[Key] !== undefined) {
                                        Set = Record[Key];
                                    }
                                    if (ElqadaDataTable.$Tables[$ID].$Rename.hasOwnProperty(Key))
                                    {
                                        $Key = ElqadaDataTable.$Tables[$ID].$Rename[Key];
                                    }
                                    if (ElqadaDataTable.$Tables[$ID].$KeyValue)
                                    {
                                        DataColumn.push({text: $Key, style: 'Key'});
                                        if (Errors.includes(Key)) {
                                            DataColumn.push({text: Set, style: 'Error'});
                                        } else {
                                            DataColumn.push({text: Set, style: 'Value' });
                                        }
                                    }
                                    else
                                    {
                                        if (Errors.includes(Key)) {
                                            DataColumn.push({
                                                text: $Key + ' : ' + Set,
                                                style: 'Error'
                                            });
                                        } else {
                                            DataColumn.push({
                                                text: $Key + ' : ' + Set,
                                                style: 'Value'
                                            });
                                        }
                                    }
                                });
                                Row.push(DataColumn);
                            });
                            TableBody.push(Row);
                        });
// PDF document definition
                        const docDefinition = {
                            pageSize: ElqadaDataTable.$Tables[$ID].$Page.Size,
                            pageOrientation: ElqadaDataTable.$Tables[$ID].$Page.Orientation,
                            pageMargins: [5, 5, 5, 5], // Top, Right, Bottom, Left margins
                            content: [
                                {
                                    text: ((ElqadaDataTable.$Tables[$ID].$Name).split(' ').join('_'))+"_"+ElqadaDataTable.$Tables[$ID].$Date.split('').reverse().join(''),
                                    style: "Title"
                                },
                                {
                                    table: {
//headerRows: 1,
                                        widths: Array(Object.keys(ElqadaDataTable.$Tables[$ID].$Report).length).fill((parseFloat((100 / Object.keys(ElqadaDataTable.$Tables[$ID].$Report).length).toString()).toFixed(1) - 0.05) + '%'),
                                        body: TableBody
                                    },
                                    layout:
                                        {
                                            fillColor: function (rowIndex) {
                                                return rowIndex % 2 === 0 ? '#f9f9f9' : null; // Zebra striping
                                            }
                                        }
                                }
                            ],
                            styles: {
                                Title: {
                                    fontSize: 12,
                                    bold: true,
                                    alignment: 'center',
                                    margin: [1, 1, 1, 3]
                                },
                                Column:
                                    {
                                        fontSize: 10,
                                        alignment: 'center',
                                        color: '#0c5700',
                                        margin: [1, 1, 1, 1]
                                    },
                                Key: {
                                    fontSize: 9,
                                    bold: true,
                                    color: '#0b0684',
                                    alignment: 'center',
                                    margin: [0, 0, 0, 0]
                                },
                                Value: {
                                    bold: true,
                                    fontSize: 8,
                                    color: '#000000',
                                    alignment: 'center',
                                    margin: [1, 1, 1, 1]
                                },
                                Error: {
                                    bold: true,
                                    fontSize: 10,
                                    color: '#FF0000',
                                    alignment: 'center',
                                    margin: [0, 0, 0, 0]
                                }
                            },
                            defaultStyle: {
                                font: "Amiri" // Change to a built-in font
                            }
                        };
// Generate and download the PDF
                        pdfMake.createPdf(docDefinition).download(((ElqadaDataTable.$Tables[$ID].$Name).split(' ').join('_'))+"_"+ElqadaDataTable.$Tables[$ID].$Date+".pdf",()=>{
                            node[0].innerHTML = 'Report';
                            node[0].disabled = false;
                        });
                    }
                    ElqadaDataTable.$Tables[$ID].$CanDownload = true;
                }
            },
            'Print' : {
                extend: 'print',
                className: "btn-success",
                exportOptions: {
                    orthogonal: "arabicPDF",
                    columns: ':visible',
                    modifier: {search: 'applied', order: 'applied'}
                },
                autoFilter: true,
                text: 'Print'
            },
            'CSV': {extend: 'csvHtml5',className: "btn-warning",autoFilter: true,exportOptions: {orthogonal: "arabicPDF", columns: ':visible',modifier:{search:'applied',order:'applied'}},text: 'CSV'},
            'PDF': {extend: 'pdf',text: 'PDF',className: "btn-danger",autoFilter: true,exportOptions: {orthogonal: "arabicPDF", columns: ':visible',modifier:{search:'applied',order:'applied'}},
                title : ((ElqadaDataTable.$Tables[$ID].$Name).split(' ').join('_'))+" "+ElqadaDataTable.$Tables[$ID].$Date,
                sheetName: ((ElqadaDataTable.$Tables[$ID].$Name).split(' ').reverse().join('_'))+"_"+ElqadaDataTable.$Tables[$ID].$Date,
                filename: ((ElqadaDataTable.$Tables[$ID].$Name).split(' ').join('_'))+"_"+ElqadaDataTable.$Tables[$ID].$Date,
                orientation: ElqadaDataTable.$Tables[$ID].$Page.Orientation, pageSize: ElqadaDataTable.$Tables[$ID].$Page.Size,
                customize: function (doc)
                {
                    doc.pageMargins = 6;
                    var objLayout = {};
                    objLayout['hLineWidth'] = function(i) { return 0.1; };
                    objLayout['vLineWidth'] = function(i) { return 0.1; };
                    objLayout['hLineColor'] = function(i) { return '#000000'; };
                    objLayout['vLineColor'] = function(i) { return '#000000'; };
                    doc.content[1].layout = objLayout;

                    doc.styles.title = { fillColor: '#02a150', fontSize: 10, bold: true, alignment: 'center' , style : 'vertical' };
                    doc.styles.tableHeader = { fillColor: '#007bff', color: 'white', bold: true, alignment : 'right', style : 'vertical' };
                    doc.styles.tableBodyEven = { fillColor: '#ffffff', fontSize: 8, bold: true, alignment: 'right' , style : 'vertical' };
                    doc.styles.tableBodyOdd = { fillColor: '#cbcbcb', fontSize: 8, bold: true, alignment: 'right' , style : 'vertical' };
                    doc.styles.tableFooter  = { fillColor: '#007bff', color: 'white', bold: true, alignment : 'right', style : 'vertical' };


                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill((parseFloat((100/doc.content[1].table.body[0].length)).toFixed(1)-0.05)+'%');

                    elqada.$Y.$O = doc;
                    doc.content[0].text = doc.content[0].text.split(' ').reverse().join(' ');

                    doc.defaultStyle = {
                        font: 'Amiri',
                        alignment: 'center'
                    };

                    const IsArabic = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF]/;
                    doc.content[1].table.body.forEach(function (Row,RowIndex,Data) {
                        let HasTotal = Row[0].text.toString().includes('@');
                        Row.alignment = 'center';
                        Row.forEach(function (Cell,CellIndex) {
                            Cell.alignment = 'center';
                            Cell.bold = true;
                            Cell.fontSize = 8;
                            Cell.style = 'vertical';

                            if (RowIndex%2)
                            {
                                Cell.fillColor = "#ffffff";
                            }
                            else
                            {
                                Cell.fillColor = "#cbcbcb";
                            }
                            if (HasTotal)
                            {
                                Cell.fillColor = "#7dc2e4";
                            }
                            if (!RowIndex)
                            {
                                Cell.fillColor = "#007bff";
                            }
                            if (IsArabic.test(Cell.text))
                            {
                                Cell.text = Cell.text.split(' ').reverse().join(' ');
                            }
                        });
                        let Errors = [];
                        if (RowIndex && typeof ElqadaDataTable.$Tables[$ID].$Data[RowIndex-1]['Error'] == 'string' && ElqadaDataTable.$Tables[$ID].$Data[RowIndex-1]['Error'].includes('@')) {
                            Errors = ElqadaDataTable.$Tables[$ID].$Data[RowIndex]['Error'].replaceAll('  -  ', '-').replace(' [ ', '').replace(' ] ', '').split('@')[1].split('-');
                        }
                        if (Errors.length)
                        {
                            Row[0].fillColor = "#e13232";
                            Errors.forEach((Error)=>{
                                let Set = ElqadaDataTable.$Tables[$ID].$Keys.indexOf(Error);
                                if (Set > -1)
                                {
                                    Row[ElqadaDataTable.$Tables[$ID].$Keys.indexOf(Error)].fillColor = "#e13232";
                                }
                            });
                        }
                        Row.forEach(function (Cell) {
                            Cell.alignment = 'center';
                        });
                        ElqadaDataTable.$Tables[$ID].PDFRow(Row,RowIndex,Data);
                    });
                },
                //download: 'open'
            },
            'Copy' : {extend: 'copyHtml5',className: "btn-dark",autoFilter: true,text: 'Copy'},
            'JSON' : {text: 'JSON',className: "btn-danger", action: (e, dt, button, config) => {var data = dt.buttons.exportData();Download(ElqadaDataTable.$Tables[$ID].$Name+'.json',JSON.stringify(data),'text/json');}},

        };
        /* ---------------------------------------=[|=>|]  [|<=|]=----------------------------------------------- */
        if ($Buttons === null || !($Buttons instanceof Array))
        {
            ElqadaDataTable.$Tables[$ID].$Buttons = ElqadaDataTable.$Buttons$;
        }
        else
        {
            $Buttons.forEach((Buttons)=>{
                if (typeof Buttons === "object" && Buttons.hasOwnProperty('ID'))
                {
                    ElqadaDataTable.$Tables[$ID].$Buttons[Buttons.ID] = Buttons;
                }
                else if (ElqadaDataTable.$Buttons$.hasOwnProperty(Buttons))
                {
                    ElqadaDataTable.$Tables[$ID].$Buttons[Buttons] = ElqadaDataTable.$Buttons$[Buttons];
                }
            });
        }
        /* ---------------------------------------=[|=>|]  [|<=|]=----------------------------------------------- */
        ElqadaDataTable.Optimize();
        /* ---------------------------------------=[|=>|]  [|<=|]=----------------------------------------------- */
        if (ElqadaDataTable.$Data.length)
        {
            ElqadaDataTable.$Tables[$ID].Install();
        }
    }
};
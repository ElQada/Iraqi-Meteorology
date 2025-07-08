<?php
$Title = "الظواهر الجوية";
$CurrentFile = "phenomena-weather";

require_once "configuration/Header.php";

$Keys = ["VV","FF","WW"];
if (_REQUEST_("ID"))
{
    if (_REQUEST_('Delete')&&_REQUEST_("Edit"))
    {
        $Value = MySqlX("SELECT * FROM `test_weather` WHERE `ID` = ? LIMIT 1", [_REQUEST_("ID")], 0);
        if (MySqlX("DELETE FROM `test_weather` WHERE `ID` = ? LIMIT 1",[_REQUEST_("ID")],'R'))
        {
            Success( 'تــم الحــذف بـنـجـاح' );
            SetRecord('0', 'DELETE', 'test_weather', _REQUEST_("ID"),json_encode($Value,256));
        }
        else
        {
            Error( 'لــم يـتــم الحــذف بـنـجـاح');
        }
    }
    elseif (_REQUEST_('Update')&&!_REQUEST_("Edit"))
    {
        $Execute = [];

        foreach (["VV","FF","WW","ID"] as $Input)
        {
            $Execute[] = _REQUEST_($Input);
        }

        if (MySqlX("UPDATE `test_weather` SET `VV` = ? ,`FF` = ? ,`WW` = ? WHERE `ID` = ? LIMIT 1",$Execute,'R'))
        {
            Success( 'تــم الـتـعـديـل بـنـجـاح' );
            SetRecord('0', 'UPDATE', 'test_weather',_REQUEST_("ID"),'');
        }
        else
        {
            Error( 'لــم يـتــم الـتـعـديـل بـنـجـاح');
        }
    }
}
elseif (_REQUEST_("Add"))
{
    $Execute = [];

    foreach (["VV","FF","WW"] as $Input)
    {
        $Execute[] = _REQUEST_($Input);
    }

    if ($ID = MySqlX("INSERT INTO `test_weather` (`VV`,`FF`,`WW`) VALUES (?,?,?)",$Execute,'K'))
    {
        Success( 'تــم الأضــافــة بـنـجـاح' );
        SetRecord('0', 'INSERT', 'test_weather',$ID,'');
    }
    else
    {
        Error( 'لــم يـتــم الأضــافــة بـنـجـاح');
    }
}

?>

    <form>
        <?php require_once "Top/".$CurrentFile.".php"; ?>
        <div class="Flex-2">
            <input type="submit" name="Refresh" value="  تـــحــديــث الـمــعــلــومــات " class="ui green button large">
            <input type="reset" onclick="DataTable.Clear()" id="Clear" name="Add" value="تـنـظـيـف الـحـقــول" class="ui blue button large">
            <input type="submit" id="Delete" name="Delete" value="حـــــــــــذف" class="ui red button large" disabled>
            <input type="submit" id="Update" name="Update" value="تــعـــديــــل" class="ui orange button large" disabled>
            <input type="submit" id="Add" name="Add" value="أضـــــافــــة" class="ui green button large">
        </div>
        <hr>
        <div class="ui container center aligned" style="width: 100%;">
            <div class="ui segment">
                <div class="Title"> الظواهر الجوية </div>
                <div class="ui Over">
                    <div id="Data-Table"></div>
                </div>
            </div>
        </div>
    </form>


    <script>
        pdfMake.fonts = {
            Amiri: {
                normal: CurrentLink+'/fonts/Amiri-Regular.ttf',
                bold: CurrentLink+'/fonts/Amiri-Bold.ttf',
                italics: CurrentLink+'/fonts/Amiri-Italic.ttf',
                bolditalics: CurrentLink+'/fonts/Amiri-BoldItalic.ttf'
            }
        };

        var DataTable = {
            $ID : 'Data-Table-Phenomena-Weather',
            ID : 'Data-Table-Phenomena-Weather',
            Inputs : <?=json_encode($_REQUEST)?>,
            Element : "Data-Table",
            Keys : ["Index","ID","VV","FF","WW","Edit"],
            $Data : <?=json_encode(MySqlX("SELECT '' as `Index`,`ID`,`VV`,`FF`,`WW`,'' as `Edit` FROM `test_weather`",[],11))?>,
            Data : [],
            Name : "Data-Table-Phenomena-Weather",
            Table : null,
            HeadRow : '',
            Titles : [],
            Clear : function (){
                DataTable.Keys.forEach((Key,Index)=>{
                    DataTable.Search(Index,'');
                });
            },
            Edit : function (Element) {
                if (Element.checked&&parseInt(Element.value))
                {
                    DataTable.Search(DataTable.Keys.indexOf('ID'),parseInt(Element.value));
                    if (DataTable.Table.context[0].nTBody.rows.item.length === 1)
                    {
                        for (let Index = 0; Index < (DataTable.Keys.length - 1); Index++)
                        {
                            SetElementValue(DataTable.Keys[Index],DataTable.Table.context[0].nTBody.rows.item(0).cells.item(Index).innerText);
                        }
                    }
                }
                else
                {
                    for (let Index = 0; Index < DataTable.Keys.length; Index++)
                    {
                        SetElementValue(DataTable.Keys[Index],'');
                    }
                    DataTable.Search(DataTable.Keys.indexOf('ID'),'');
                }
            },
            Search : function (Index,Value)
            {
                if (DataTable.Keys.hasOwnProperty(Index))
                {
                    let Key = DataTable.Keys[Index];
                    SetElementValue(Key,Value);
                    DataTable.Inputs[Key] = Value;
                    if (Key === 'ID' && Value !== '')
                    {
                        DataTable.Table.column(Index).search(new RegExp("^"+Value+"$")).draw();
                    }
                    else if (Key === 'Edit' && Value !== '')
                    {
                        if (document.getElementById('Edit@'+Value))
                        {
                            document.getElementById('Edit@'+Value).checked = true;
                        }
                        else
                        {
                            DataTable.Search(DataTable.Keys.indexOf("ID"),"");
                        }
                    }
                    else if (Key === 'Index' && Value !== '' && !VarID('ID') && DataTable.Data.hasOwnProperty(Value))
                    {
                        let ID = DataTable.Data[Value-1][DataTable.Keys.indexOf("ID")];
                        DataTable.Search(DataTable.Keys.indexOf("ID"),ID);
                        if (document.getElementById('Edit@'+ID))
                        {
                            document.getElementById('Edit@'+ID).checked = true;
                        }
                        else
                        {
                            DataTable.Search(DataTable.Keys.indexOf("ID"),"");
                        }
                    }
                    else
                    {
                        DataTable.Table.column(Index).search(Value).draw();
                    }
                    let $Delete = (DataTable.Inputs.hasOwnProperty('ID') && DataTable.Inputs.ID > 0);
                    let $Update = !($Delete && !(document.getElementById('Edit@'+DataTable.Inputs.ID) && document.getElementById('Edit@'+DataTable.Inputs.ID).checked));
                    Disabled('Update',$Update);
                    Disabled('Delete',!($Delete && $Update));
                    Disabled('Add',$Delete);
                }
            },
            Install : function ()
            {
                DataTable.Titles = [];
                DataTable.HeadRow = '';
                DataTable.Keys.forEach((K)=>
                {
                    DataTable.Titles.push(K);
                    DataTable.HeadRow += `<th>${K}</th>`;
                });
                /* --------------------------=[|=>|]  [|<=|]=-------------------------- */
                DataTable.Data = [];
                DataTable.$Data.forEach((Row)=>
                {
                    DataTable.Data.push(Object.values(Row));
                });
                /* --------------------------=[|=>|]  [|<=|]=-------------------------- */
                window.addEventListener('DOMContentLoaded',() => {
                    document.getElementById(DataTable.Element).innerHTML = `<table id="${DataTable.ID}" data-id="${DataTable.$ID}" class="table table-striped table-bordered"> <thead><tr>${DataTable.HeadRow}</tr></thead> <tbody></tbody> <tfoot><tr>${DataTable.HeadRow}</tr></tfoot> </table>`;

                    setTimeout(() => {

                        $("#"+DataTable.ID+" tfoot th").each(function (Index, Element)
                        {
                            let SetID = DataTable.Keys[Index];
                            if (SetID === 'Edit')
                            {
                                $(Element).html(`<input type="radio" name="${SetID}" id="${SetID}" value="" class="Search" data-index="${Index}" onchange="DataTable.Edit(this)" checked/>`);
                            }
                            else if (SetID === 'ID')
                            {
                                $(Element).html(`<input type="text" placeholder="" name="${SetID}" id="${SetID}" value="" class="Search" data-index="${Index}"/>`);
                            }
                            else
                            {
                                $(Element).html(`<input type="text" placeholder="" name="${SetID}" id="${SetID}" value="" class="Search" data-index="${Index}"/>`);
                            }
                        });

                        // DataTable initialisation
                        DataTable.Table = $("#"+DataTable.ID).DataTable({
                            "dom": '<"dt-buttons"Bf><"clear">lirtp',
                            order: [DataTable.Keys.indexOf('Index'), 'asc'],
                            paging: true,
                            lengthMenu: [[50, 100, 200, 400, 800, 1200, 2400, 4800, -1], [50, 100, 200, 400, 800, 1200, 2400, 4800, 'All']],
                            autoWidth: true,
                            lengthChange: true,
                            data: DataTable.Data,
                            buttons:
                            [
                                {extend: 'colvis',className: "btn-light",text: 'Select View'},
                                {extend: 'colvisRestore',text: 'View All',className: "btn-success"},
                                {extend: 'excelHtml5', text: 'Excel',className: "btn-info",autoFilter: true,sheetName: DataTable.Name,filename: DataTable.Name, messageTop: 'Sheet created Name : ' + DataTable.Name + ' @ ' + (new Date()).toLocaleDateString(),
                                    customize: function (xlsx) {
                                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                        $('col', sheet).attr('width', 20); // Set width for column A
                                        $('c', sheet).attr( 's', '51' );
                                    }
                                },
/*
                                {extend: 'csvHtml5',className: "btn-warning",autoFilter: true,text: 'CSV'},
*/
                                //{extend: 'pdf',text: 'PDF',className: "btn-primary",autoFilter: true,exportOptions: {orthogonal: "arabicPDF", columns: ':visible'},filename: DataTable.Name,orientation: 'landscape', pageSize: 'A4', /*download: 'open'*/},
                                //{text: 'JSON',className: "btn-danger", action: (e, dt, button, config) => {var data = dt.buttons.exportData();Download(`${DataTable.Name}.json`,JSON.stringify(data),'text/json');}},
                                //{extend: 'copyHtml5',className: "btn-dark",autoFilter: true,text: 'Copy'},
                                //{extend: 'print',className: "btn-primary",autoFilter: true,text: 'Print'}
                                {extend: 'pdf',text: 'PDF',className: "btn-danger",autoFilter: true,exportOptions: {orthogonal: "arabicPDF", columns: ':visible'},filename: DataTable.Name,orientation: 'landscape', pageSize: 'A3',
                                    customize: function (doc)
                                    {
                                        doc.pageMargins = 10;
                                        var objLayout = {};
                                        objLayout['hLineWidth'] = function(i) { return 0.5; };
                                        objLayout['vLineWidth'] = function(i) { return 0.5; };
                                        objLayout['hLineColor'] = function(i) { return '#000000'; };
                                        objLayout['vLineColor'] = function(i) { return '#000000'; };
                                        doc.content[1].layout = objLayout;

                                        doc.styles.title = { fontSize: 12, bold: true, alignment: 'center' };
                                        doc.styles.tableHeader = { fillColor: '#007bff', color: 'white', bold: true };
                                        doc.styles.tableBodyEven = { fillColor: '#f3f3f3' };
                                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill((parseFloat((100/doc.content[1].table.body[0].length)).toFixed(1)-0.1)+'%');

                                        elqada.$Y.$O = doc;
                                        doc.content[0].text = doc.content[0].text.split(' ').reverse().join(' ');
                                        // Set the font to Amiri
                                        doc.defaultStyle = {
                                            font: 'Amiri', // Use the Arabic font
                                            alignment: 'center' // Align text to the right for RTL
                                        };

                                        // Set content alignment (for table content)
                                        doc.content[1].table.body.forEach(function (row) {
                                            row.forEach(function (cell) {
                                                cell.alignment = 'center';
                                            });
                                        });

                                        doc.content[1].table.body[0].forEach(function (cell,Index) {
                                            doc.content[1].table.body[0][Index].text = cell.text.split(' ').reverse().join(' ');
                                        });
                                    },
                                    /*download: 'open'*/},
                                {extend: 'print',className: "btn-success",autoFilter: true,text: 'Print'}
                            ],
                            /*                columnDefs:
                [
                    {
                        targets: [0,1,2,3,4,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18],
                        render: function (data, type, row) {
                            return data;
                        }
                }],*/
                            // fixedHeader: true,
                            createdRow: function (row, data, dataIndex) {
                                row.cells.item(0).innerText = (dataIndex + 1);
                                for (let I = 1; I < row.childElementCount-1; I++)
                                {
                                    row.cells.item(I).title = DataTable.Titles[I];
                                }
                                let Value = parseInt(row.cells.item(1).innerText);
                                row.cells.item((row.childElementCount-1)).innerHTML = `<input type="radio" name="Edit" id="Edit@${Value}" value="${Value}" onchange="DataTable.Edit(this)">`;
                            },
                            initComplete: function (settings, json) {
                                var footer = $("#" + DataTable.ID + " tfoot tr");
                                $("#" + DataTable.ID + " thead").append(footer);
                            }
                        });

                        // Apply the search
                        $("#" + DataTable.ID + " thead").on("keyup", "input", "change", function (Event)
                        {
                            // DataTable.Search(Event.currentTarget.parentElement.parentElement.cellIndex,Event.currentTarget.value);
                        });

                        DataTable.Keys.forEach((Key,Index)=>{
                            if (Key !== 'ID')
                            {
                                document.getElementById(Key).addEventListener('focus',()=>
                                {
                                    SetElementValue(Key,'');
                                    DataTable.Search(Index,'');
                                });
                            }
                        });

                        ["Index","ID"].forEach((Key)=>{
                            InputFormating(Key,5,0,1,null,2,null,null,(ID,$Error,$Message)=>{
                                DataTable.Search(DataTable.Keys.indexOf(ID),GetElementValue(ID));
                            },(ID,Value,Message)=>{
                                if (Value === '')
                                {
                                    return false;
                                }
                                else
                                {
                                    Value = parseInt(Value);
                                    SetElementValue(ID,Value);
                                    return (Value < 0);
                                }
                            },'0123456789',[]);
                        });

                        ['FF','WW'].forEach(($Input)=>{
                            InputFormating($Input,2,0,0,99,null,null,null,(ID,$Error,$Message)=>{
                                DataTable.Search(DataTable.Keys.indexOf(ID),GetElementValue(ID));
                            },(ID,Value,Message)=>{
                                if (Value === '')
                                {
                                    return false;
                                }
                                else
                                {
                                    Value = parseInt(Value);
                                    return (Value < 0);
                                }
                            },'0123456789',[]);
                        });

                        ['VV'].forEach(($Input)=>{
                            InputFormating($Input,2,0,0,99,null,null,null,(ID,$Error,$Message)=>{
                                DataTable.Search(DataTable.Keys.indexOf(ID),GetElementValue(ID));
                            },(ID,Value,Message)=>{
                                if (Value === '')
                                {
                                    return false;
                                }
                                else
                                {
                                    Value = parseInt(Value);
                                    return (Value <= 55 && Value >= 51 || Value>60);
                                }
                            },'0123456789',[]);
                        });

                        setTimeout(()=>{
                            Object.keys(DataTable.Inputs).forEach((K)=>
                            {
                                DataTable.Search(DataTable.Keys.indexOf(K),DataTable.Inputs[K]);
                            });

                        },125);
                    }, 125);
                });
            }
        };
        DataTable.Install();
    </script>

<?php require_once "configuration/Footer.php"; ?>
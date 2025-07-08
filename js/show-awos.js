document.addEventListener('DOMContentLoaded',()=>
{
    document.getElementById('Nav').addEventListener('dblclick',()=>{
        document.body.requestFullscreen();
    });
/* ---------------------------------------------------------------------------------------------------------------------
==|-  -|==>
--------------------------------------------------------------------------------------------------------------------- */

    // Load the Visualization API and the corechart package.
    // Instantiate and draw our chart, passing in some options. || ColumnChart || BarChart || LineChart || PieChart || AreaChart ||
    // CoreChart || ComboChart  || BubbleChart || ScatterChart || SparklineChart || CandlestickChart || SteppedAreaChart || drawChart
    var packages = ['ColumnChart','BarChart','LineChart','PieChart','AreaChart','CoreChart','ComboChart ','BubbleChart','ScatterChart','SparklineChart','CandlestickChart','SteppedAreaChart','drawChart'];
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {
        // Create the data table.
        var data = google.visualization.arrayToDataTable(ChartShowAwos);



// Set chart options
        var options =
        {
            title:' Q N H ',
            fontSize : 14,
            color:"#000000",
            titleTextStyle:
                {
                    fontName: 'Times-Roman',
                    fontSize: 18,
                    bold: true,
                    italic: false,
                    // The color of the text.
                    color: '#000000',
                    // The color of the text outline.
                    auraColor: '#7dc2e4',
                    // The transparency of the text.
                    opacity: 0.75
                },
            tooltip:
                {
                    textStyle:
                        {
                            fontName: 'Times-Roman',
                            fontSize: 16,
                            bold: true,
                            italic: false,
                            // The color of the text.
                            color: '#000000',
                            // The color of the text outline.
                            auraColor: '#ffffff',
                            // The transparency of the text.
                            opacity: 0.75
                        },
                    showColorCode: true,
                    trigger:"selection",
                },
            width:'90%',
            legend: { position: 'bottom' },
            bar: { groupWidth: '100%' },
            isStacked: true ,
            hAxis:
                {
                    minValue:950,
                    maxValue:1050,
                    ticks: [950,960,970,980,990,1000,1010,1020,1030,1040,1050],
                    textStyle:
                        {
                            fontName: 'Times-Roman',
                            fontSize: 14,
                            bold: true,
                            italic: false,
                            // The color of the text.
                            color: '#000000',
                            // The color of the text outline.
                            auraColor: '#ffffff',
                            // The transparency of the text.
                            opacity: 0.75
                        },
                    textPosition:"out"
                },
            lineWidth:3,
            pointsVisible:true,
            pointSize:8,
            curveType: 'function',
            annotations: {
                textStyle: {
                    fontName: 'Times-Roman',
                    fontSize: 18,
                    bold: true,
                    italic: true,
                    // The color of the text.
                    color: '#871b47',
                    // The color of the text outline.
                    auraColor: '#d799ae',
                    // The transparency of the text.
                    opacity: 0.8
                }
            }
            /*annotations: {
                textStyle: {
                    fontName: 'Times-Roman',
                    fontSize: 14,
                    bold: true,
                    italic: false,
                    // The color of the text.
                    color: '#ffffff',
                    // The color of the text outline.
                    auraColor: '#000000',
                    // The transparency of the text.
                    opacity: 1.0
                }
            }*/
        };

        var chart = new google.visualization[packages[2]](document.getElementById('chart_div'));
        chart.draw(data, options);
    }
});

function Awos()
{
    SetElementValue('AirportTitle',"Wait Data is Processing Now ...")
    Request('Request/show-awos.php?Request=true&Station='+GetElementValue('Station'),(Response)=>
    {
        if (Response)
        {
            SetElementValue(Object.keys(Response),Object.values(Response));
            SetElementValue('AirportTitle',GetElementValue('Station').replaceAll(' AIRPORT','')+" International Airport")
        }
    });
}

function timech(File)
{

}
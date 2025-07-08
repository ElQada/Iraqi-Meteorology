function timech(File)
{

}

ElqadaDataTable.$Page.Size = 'A3';
ElqadaDataTable.CreatedRow = function (Row,Data,Index) {
    if ($AllStations[Index]['Days'] !== $AllStations[Index]['Count'])
    {
        Row.cells.item(0).style.backgroundColor = '#e13232';
        Row.cells.item(2).style.backgroundColor = '#e13232';
    }
};
ElqadaDataTable.PDFRow = function (Row,Index,Data) {
    if (Index && $AllStations[Index-1]['Days'] !== $AllStations[Index-1]['Count'])
    {
        Row[0].fillColor = "#e13232";
        Row[2].fillColor = "#e13232";
    }
};
ElqadaDataTable.ID('Stations-Month-Daily')
    .Name('المعدلات الشهرية للرصد اليومي').Element('Month-Daily')
    .Rename({'Range':'الفترة','Days':'عدد الايام','Count':'عدد الرصدات','Div':'معدل القسمة'}).Data($AllStations)
    .Keys(['Station','Range','Count','ResultWind50','ResultWind200','ResultRain','ResultEvapration','CannabisTemperature','SunShine','ff','dd','min_day','max_day','Main+5CM','MainSUR','Main-5CM','Main-10CM','Main-20CM','Main-50CM','Main-100CM'])
    .Length({"50":50,"100":100})
    .Set(['Select','Reselect','PDF','Excel','Print']);
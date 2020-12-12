<script>

    if ((isLoginChecked != 1 && userSubscriptionStatus)) {
        $('#subscription-login-modal').modal();
    }


    $("#invoices-chart-container").insertFusionCharts({
        type: "column2d",
        width: "100%",
        height: "100",
        id: "chart1",
        dataFormat: "json",
        dataSource: {
            chart: {
                paletteColors: "#13c67f",
                showvalues: "0",
                divlinealpha: "30",
                numdivlines: "3",
                showlabels: "0",
                showYAxisValues: "0",
                yAxisMaxValue: "10",
                palettecolors: "13c67f",
                plotspacepercent: "0",
                chartLeftMargin: "0",
                chartRightMargin: "0",
                plotToolText: "<div><b>$label, <br/>invoices: $datavalue</b></div>",
                theme: "zune",
            },
            data: @php echo $invoiceDailyCount @endphp, //from data.js
        },
    });


    //Creating Page Views Chart for that month
    $("#false-document-container").insertFusionCharts({
        type: "column2d",
        id: "chart2",
        width: "100%",
        height: "100",
        dataFormat: "json",
        dataSource: {
            chart: {
                paletteColors: "#ec8078",
                showvalues: "0",
                divlinealpha: "30",
                numdivlines: "3",
                showlabels: "0",
                showYAxisValues: "0",
                yAxisMaxValue: "10",
                palettecolors: "ec8078",
                plotspacepercent: "0",
                chartLeftMargin: "0",
                chartRightMargin: "0",
                plotToolText: "<div><b>$label, <br/>False Documents: $datavalue</b></div>",
                theme: "zune",
            },
            data: @php echo $falseDocumentDailyCount @endphp, //from data.js
        },
    });


    //Creating Avg. session duration Chart for that month
    $("#supplier-not-verified-container").insertFusionCharts({
        type: "column2d",
        id: "chart3",
        width: "100%",
        height: "100",
        dataFormat: "json",
        dataSource: {
            chart: {
                paletteColors: "#ffcb61",
                showvalues: "0",
                divlinealpha: "30",
                numdivlines: "3",
                showlabels: "0",
                showYAxisValues: "0",
                yAxisMaxValue: "10",
                palettecolors: "ffcb61",
                plotspacepercent: "0",
                chartLeftMargin: "0",
                chartRightMargin: "0",
                plotToolText: "<div><b>$label, <br/>Suppliers: $value</b></div>",
                theme: "zune",
            },
            data: @php echo $notVerifiedSupplierDailyCount @endphp, //from data.js
        },
    });


    $("#savings-count-container").insertFusionCharts({
        type: "column2d",
        id: "chart4",
        width: "100%",
        height: "100",
        dataFormat: "json",
        dataSource: {
            chart: {
                paletteColors: "#048800",
                showvalues: "0",
                divlinealpha: "30",
                numdivlines: "3",
                showlabels: "0",
                showYAxisValues: "0",
                yAxisMaxValue: "10",
                palettecolors: "048800",
                plotspacepercent: "0",
                chartLeftMargin: "0",
                chartRightMargin: "0",
                plotToolText: "<div><b>$label, <br/>Savings: $value</b></div>",
                theme: "zune",
            },
            data: @php echo $savingsDailyCount @endphp, //from data.js
        },
    });
</script>

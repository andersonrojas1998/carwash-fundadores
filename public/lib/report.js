
$(document).ready(function() {

    var ingreso=0,egresos=0;    


    $(document).on("click","#btn_showChartApproved",function(){ 
        
        let period=$("#sel_periodScore").val();
        let grade=$("#sel_gradeScore").val();

        if(grade==''){
            sweetMessage('\u00A1Atenci\u00f3n!', 'Por favor complete  los campos requeridos.', 'warning');
        }

        $("#barChart").empty();

        $.ajax({ 
            url:'/Reportes/getReportApproved/'+period+'/'+grade,            
            type:"GET",
            success:function(data){
                var stackedbarChartCanvas = $("#barChart")
                .get(0)
                .getContext("2d");                
                let arr=JSON.parse(data); 
                var stackedbarChart = new Chart(stackedbarChartCanvas, {
                    type: "bar",
                    data: {
                        labels:   arr.asignatura,
                        datasets: [
                            {
                                label: "No Aprobaron",
                                backgroundColor: ChartColor[2],
                                borderColor: ChartColor[2],
                                borderWidth: 1,
                                data:  arr.perdidas
                            },
                            {
                                label: "Aprobaron",
                                backgroundColor: ChartColor[1],
                                borderColor: ChartColor[1],
                                borderWidth: 1,
                                data:  arr.aprovadas
                            }
                        ]
                    },
                    options: {
                    
                        scales: {
                            xAxes: [
                                {
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Estudiantes vs Asignaturas",
                                        fontColor: chartFontcolor,
                                        fontSize: 12,
                                        lineHeight: 2
                                    },
                                    ticks: {
                                        fontColor: chartFontcolor,                                      
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false,
                                        color: chartGridLineColor,
                                        zeroLineColor: chartGridLineColor
                                    }
                                }
                            ],
                            yAxes: [
                                {
                                    display: true,                                   
                                    ticks: {
                                        fontColor: chartFontcolor,                                       
                                        min: 0,
                                        max: 60,                                     
                                    },                                   
                                }
                            ]
                        },
                        legend: {
                            display: true
                        },
                        legendCallback: function(chart) {
                            var text = [];
                            text.push('<div class="chartjs-legend"><ul>');
                            for (var i = 0; i < chart.data.datasets.length; i++) {
                               // console.log(chart.data.datasets[i]); // see what's inside the obj.
                                text.push("<li>");
                                text.push(
                                    '<span style="background-color:' +
                                        chart.data.datasets[i].backgroundColor +
                                        '">' +
                                        "</span>"
                                );
                                text.push(chart.data.datasets[i].label);
                                text.push("</li>");
                            }
                            text.push("</ul></div>");
                            return text.join("");
                        },
                        elements: {
                            point: {
                                radius: 0
                            }
                        }
                    }
                });
                document.getElementById(
                    "stacked-bar-traffic-legend"
                ).innerHTML = stackedbarChart.generateLegend();
        }
        });
    });
    $(document).on("click","#btn_add_ex",function(){ 
        let id_concepto=$('#id_concepto').val();
        let total_egreso=$('#total_egreso').val();
       $.ajax({
            url:'/reports/add_expenses',
            type: "POST",
            data:{'id_concepto':id_concepto,'total_egreso':total_egreso},
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},            
            success:function(data){
                if(data==1){
                    sweetMessage('\u00A1Registro exitoso!', '\u00A1 Se ha realizado con \u00E9xito su solicitud!');
                    setTimeout(function () { location.reload() }, 2000)
                   }
            }

        })
    });
    $(document).on("click","#btn_createdExpense",function(){ 
        $.ajax({ url:"/reports/concept_expenses",type:"GET",success:function(data){
            let arr=JSON.parse(data);
           // console.log(arr);
            for(let i=0;i<arr.length;i++){                    
                $('#id_concepto').append('<option   value="'+arr[i].id+'" >'+ firstLetter(arr[i].concepto.toLowerCase())  +'</option>');            
            }
            $('#id_concepto').select2();            
        }
        });
    });
    if ($("#chart_salesxmonth").length) {

         $.ajax({ 
            url:'/reports/getSalesxMonth',
            type:"GET",
            success:function(data){
                let arr=JSON.parse(data); 

                var barChartCanvas = $("#chart_salesxmonth")
            .get(0)
            .getContext("2d");
        var barChart = new Chart(barChartCanvas, {
            type: "bar",
            data: {
                labels: [
                    "Ene",
                    "Feb",
                    "Mar",
                    "Abr",
                    "May",
                    "Jun",
                    "Jul",
                    "Agos",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dic"
                ],
                datasets: [
                    {
                        label: "ventas",
                        data: arr,
                        backgroundColor: ChartColor[0],
                        borderColor: ChartColor[0],
                        borderWidth: 0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
               layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [
                        {
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: "ventas por año",
                                fontColor: chartFontcolor,
                                fontSize: 9,
                                lineHeight: 2
                            },                          
                            gridLines: {
                                display: false,
                                drawBorder: false,
                                color: chartGridLineColor,
                                zeroLineColor: chartGridLineColor
                            }
                        }
                    ],
                    yAxes: [
                        {
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: "cantidad por mes",
                                fontColor: chartFontcolor,
                                fontSize: 12,
                                lineHeight: 2
                            },
                            ticks: {
                                display: true,
                                autoSkip: false,
                                maxRotation: 0,
                                fontColor: chartFontcolor,
                                stepSize: 50,
                                min: 0,                               
                            },
                            gridLines: {
                                drawBorder: false,
                                color: chartGridLineColor,
                                zeroLineColor: chartGridLineColor
                            }
                        }
                    ]
                },
                legend: {
                    display: false
                },
                legendCallback: function(chart) {
                    var text = [];
                    text.push('<div class="chartjs-legend"><ul>');
                    for (var i = 0; i < chart.data.datasets.length; i++) {
                        //console.log(chart.data.datasets[i]); // see what's inside the obj.
                        text.push("<li>");
                        text.push(
                            '<span style="background-color:' +
                                chart.data.datasets[i].backgroundColor +
                                '">' +
                                "</span>"
                        );
                        text.push(chart.data.datasets[i].label);
                        text.push("</li>");
                    }
                    text.push("</ul></div>");
                    return text.join("");
                },
                elements: {
                    point: {
                        radius: 0
                    }
                }
            }
        });
        document.getElementById(
            "bar-traffic-legend"
        ).innerHTML = barChart.generateLegend();

            }
        });


        
    }
    if ($("#chart_salesxday").length) {

        $.ajax({ 
            url:'/reports/getSalesxDay/',  
            type:"GET",
            success:function(data){                            
                let arr=JSON.parse(data); 
               // console.log( Object.values(arr.label));
                var lineData = {
                    labels:  Object.values(arr.label)  ,
                    datasets: [
                        {
                            data: Object.values(arr.cantidad),
                            backgroundColor: ChartColor[0],
                            borderColor: ChartColor[0],
                            borderWidth: 3,
                            fill: "ventas",
                            label: "ventas cant."
                        }
                    ]
                };
                var lineOptions = {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        filler: {
                            propagate: false
                        }
                    },
                    scales: {
                        xAxes: [
                            {
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: "Dias",
                                    fontSize: 12,
                                    lineHeight: 2,
                                    fontColor: chartFontcolor
                                },
                              
                            }
                        ],
                        yAxes: [
                            {
                               display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: "Cantidad de Ventas",
                                    fontSize: 12,
                                    lineHeight: 2,
                                    fontColor: chartFontcolor
                                },
                                ticks: {                                  
                                    maxRotation: 0,
                                    stepSize: 100,
                                    min: 0,                                  
                                },
                              
                            }
                        ]
                    },
                    legend: {
                        display: false
                    },
                    legendCallback: function(chart) {
                        var text = [];
                        text.push('<div class="chartjs-legend"><ul>');
                        for (var i = 0; i < chart.data.datasets.length; i++) {
                          //  console.log(chart.data.datasets[i]); // see what's inside the obj.
                            text.push("<li>");
                            text.push(
                                '<span style="background-color:' +
                                    chart.data.datasets[i].borderColor +
                                    '">' +
                                    "</span>"
                            );
                            text.push(chart.data.datasets[i].label);
                            text.push("</li>");
                        }
                        text.push("</ul></div>");
                        return text.join("");
                    },
                    elements: {
                        line: {
                            tension: 0
                        },
                        point: {
                            radius: 0
                        }
                    }
                };
                var lineChartCanvas = $("#chart_salesxday")
                    .get(0)
                    .getContext("2d");
                var lineChart = new Chart(lineChartCanvas, {
                    type: "line",
                    data: lineData,
                    options: lineOptions
                });
                document.getElementById(
                    "line-traffic-legend"
                ).innerHTML = lineChart.generateLegend();
            }
        });
        
    }
    if ($("#dt_expenses_month").length){
        dt_expenses_month();      
    } 
    if ($("#chart_income_service").length) {
        $.ajax({ 
            url:'/reports/chart_income_service', 
            type:"GET",
            success:function(data){
                let d= JSON.parse(data);
                
                $('#product_income').html('$ ' + d.product);
                $('#service_income').html('$ ' + d.service);
                $('#total_income').html('$ ' + d.total);
                $('#inp_hd_total_inc').val(d.product+d.service);          
               var pieChartCanvas = $("#chart_income_service")
                .get(0)
                .getContext("2d");
            var pieChart = new Chart(pieChartCanvas, {
                type: "pie",
                data: {
                    datasets: [
                        {
                            data:  [d.service,d.product],
                            backgroundColor: [
                                ChartColor[0],
                                ChartColor[1],                            
                            ],
                            borderColor: [
                                ChartColor[0],
                                ChartColor[1],                            
                            ]
                        }
                    ],
                    labels: ["Servicios", "Productos"]
                },
                options: {
                    responsive: true,
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    },
                    legend: {
                        display: false
                    },
                    legendCallback: function(chart) {
                        var text = [];
                        text.push('<div class="chartjs-legend"><ul>');
                        for (
                            var i = 0;
                            i < chart.data.datasets[0].data.length;
                            i++
                        ) {
                            text.push(
                                '<li><span style="background-color:' +
                                    chart.data.datasets[0].backgroundColor[i] +
                                    '">'
                            );
                            text.push("</span>");
                            if (chart.data.labels[i]) {
                                text.push(chart.data.labels[i]);
                            }
                            text.push("</li>");
                        }
                        text.push("</div></ul>");
                        return text.join("");
                    }
                }
            });
            document.getElementById(
                "pie-chart-legend"
            ).innerHTML = pieChart.generateLegend();
            var e=$('#inp_hd_total_exp').val();
            var i=$('#inp_hd_total_inc').val();
            $('#total_op').html('$ ' + new Intl.NumberFormat().format(i-e)); 

            

            }
        });
    }
    if ($("#char_utility_month").length) {



        $.ajax({ 
            url:'/reports/getUtilityMonth', 
            type:"GET",
            success:function(data){
            let d= JSON.parse(data);
        //console.log(d);
            var stackedbarChartCanvas = $("#char_utility_month")
            .get(0)
            .getContext("2d");
        var char_utility_month = new Chart(stackedbarChartCanvas, {
            type: "bar",
            data: {                
                labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Agos","Sep","Oct","Nov","Dic"],
                datasets: [
                    {
                        label: "Ingresos",
                        backgroundColor: ChartColor[1],
                        borderColor: ChartColor[1],
                        borderWidth: 1,
                        data: Object.values(d.income)
                    },
                    {
                        label: "Egresos",
                        backgroundColor: ChartColor[2],
                        borderColor: ChartColor[2],
                        borderWidth: 1,
                        data: Object.values(d.expenses)
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                legend: false,
                categoryPercentage: 0.5,
                stacked: true,
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [
                        {
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: "Total de Ingreso y Egresos",
                                fontColor: chartFontcolor,
                                fontSize: 12,
                                lineHeight: 2
                            },
                            ticks: {
                                fontColor: chartFontcolor,
                                stepSize: 50,                                
                                autoSkip: true,
                                autoSkipPadding: 15,
                                maxRotation: 0,
                                maxTicksLimit: 12
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false,
                                color: chartGridLineColor,
                                zeroLineColor: chartGridLineColor
                            }
                        }
                    ],
                    yAxes: [
                        {
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: "Valor en pesos",
                                fontColor: chartFontcolor,
                                fontSize: 12,
                                lineHeight: 2
                            },                         
                        }
                    ]
                },               
                legendCallback: function(chart) {
                    var text = [];
                    text.push('<div class="chartjs-legend"><ul>');
                    for (var i = 0; i < chart.data.datasets.length; i++) {
                       // console.log(chart.data.datasets[i]); // see what's inside the obj.
                        text.push("<li>");
                        text.push(
                            '<span style="background-color:' +
                                chart.data.datasets[i].backgroundColor +
                                '">' +
                                "</span>"
                        );
                        text.push(chart.data.datasets[i].label);
                        text.push("</li>");
                    }
                    text.push("</ul></div>");
                    return text.join("");
                },
                elements: {
                    point: {
                        radius: 0
                    }
                }
            }
        });
        document.getElementById(
            "stacked-bar-traffic-legend"
        ).innerHTML = char_utility_month.generateLegend();

            }
        });    



        
    }
});


var dt_expenses_month=function(){

    $('#dt_expenses_month').DataTable({         
         ajax: {
            url: "/reports/dt_expenses_month",
            method: "GET", 
            async: false,
            dataSrc: function (json) { 
              
                $('#inp_hd_total_exp').val(json.total);          
                $('#total_exp').html('$  ' + new Intl.NumberFormat().format(json.total));          
                if (!json.data) {
                    return [];
                } else {
                    return json.data;
                }
              }               
            },
        "lengthMenu": [ 6, 14, 21, "All" ],
        columnDefs: [                  
            { orderable: false, targets: '_all' }
        ],       
        columns: 
        [       
            { "data": "no" , render(data){return '<p class="text-muted">'+data+'</p>';}},         
            { "data": "concepto" , render(data){return '<b>'+data+'</b>';}},         
            { "data": "valor",render(data,type,row){ return  '$. ' + data; }},                                
        ],       
    });
}




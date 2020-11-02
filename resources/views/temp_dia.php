
    <?php

        function temperatura_diaria($datos,$dato_ini) {
            $dibujar = false;
            //Para que resultado sea legible
            foreach($datos as $dato)
            {
                //Lo que hago es transformarlo en un array y guardarlo en la variable row
                if(strcmp($dato->fecha,$dato_ini)==0)
                    $dibujar = true;
                if($dibujar){
                    echo "[";
                    echo (strtotime($dato->fecha)*1000 -10800000); //numero de segundos que transcurrieron * 1000 porque la libreria pide en ms
                    echo ",";
                    echo $dato->temperatura;
                    echo "],";
                }
            }            
        }

    ?>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <script>
    Highcharts.chart('container', {
        chart: {
            type: 'spline',
            zoomType: 'x'
        },
        title: {
            text: 'Temperatura de tu cerveza'
        },
        xAxis: {
            type: 'datetime'
        },
        yAxis: {
            title: {
                text: 'Temperatura'
            }
        },
        series: [{
            name: 'Temp',
            data: [<?php temperatura_diaria($datos,$dato_ini);?>       
        ]
        }]
    });
    </script>

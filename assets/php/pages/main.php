<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../scss/style.css">
    <link rel="shortcut icon" href="../../images/icons/shield_var_1.png" type="image/x-icon">
    <link rel="stylesheet" href="../../bootstrap-5.0.1-dist/css/bootstrap.min.css">
    <title>Главная страница</title>
</head>

<body class="main">

    <!-- Preloader -->
    <div class="mask">
        <div class="loader"></div>
    </div>

    <div class="container">
        <div class="row content">

            <!-- Титул -->
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="main__title">Анализ региона</h1>
                </div>
            </div>

            <!-- Доступные регионы -->
            <div class="row">
                <div class="col-2 region">
                    <div class="row">
                        <div class="col-12 text-center region__menu">
                            <div class="region__menu-title">Регионы России</div>
                            <div class="region__menu-item">Брянская область</div>
                            <div class="region__menu-item">Брянская область</div>
                            <div class="region__menu-item">Брянская область</div>
                            <div class="region__menu-item">Брянская область</div>
                            <div class="region__menu-item">Брянская область</div>
                            <div class="region__menu-item">Брянская область</div>
                        </div>
                    </div>
                </div>

                <!-- График -->
                <div class="col-8 graph">
                    <canvas id="myChart" width="600" height="300"></canvas>
                </div>

                <!-- Настройки графика -->
                <div class="col-2 options">
                    <div class="row">
                        <div class="col-12 text-center options__menu">
                            <div class="options__menu-title">Доступные опции</div>
                            <div class="options__menu-item">Кол-во пострадвших</div>
                            <div class="options__menu-item">Общая статистика</div>
                            <div class="options__menu-item">Процент пострадвших</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="../../js/canvas.js"></script>
<script src="../../js/preloader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.querySelector("#myChart").getContext("2d");

// -- Setup
const data = {
    labels: ["Раз", "Два", "Три", "Четыре", "Раз", "Два", "Три"],
    datasets: [{
        label: ['Название области'],
        data: [65, 59, 80, 81, 56, 55, 40],
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 205, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
        ],
        borderWidth: 1
    }]
};

// -- Config
const config = {
    type: 'bar',
    data: data,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
};

// -- Pie chart
const myChart = new Chart(ctx, config);

// -- Actions
const actions = [{
        name: 'Randomize',
        handler(chart) {
            chart.data.datasets.forEach(dataset => {
                dataset.data = Utils.numbers({
                    count: chart.data.labels.length,
                    min: 0,
                    max: 100
                });
            });
            chart.update();
        }
    },
    {
        name: 'Add Dataset',
        handler(chart) {
            const data = chart.data;
            const newDataset = {
                label: 'Dataset ' + (data.datasets.length + 1),
                backgroundColor: [],
                data: [],
            };

            for (let i = 0; i < data.labels.length; i++) {
                newDataset.data.push(Utils.numbers({
                    count: 1,
                    min: 0,
                    max: 100
                }));

                const colorIndex = i % Object.keys(Utils.CHART_COLORS).length;
                newDataset.backgroundColor.push(Object.values(Utils.CHART_COLORS)[colorIndex]);
            }

            chart.data.datasets.push(newDataset);
            chart.update();
        }
    },
    {
        name: 'Add Data',
        handler(chart) {
            const data = chart.data;
            if (data.datasets.length > 0) {
                data.labels.push('data #' + (data.labels.length + 1));

                for (let index = 0; index < data.datasets.length; ++index) {
                    data.datasets[index].data.push(Utils.rand(0, 100));
                }

                chart.update();
            }
        }
    },
    {
        name: 'Remove Dataset',
        handler(chart) {
            chart.data.datasets.pop();
            chart.update();
        }
    },
    {
        name: 'Remove Data',
        handler(chart) {
            chart.data.labels.splice(-1, 1); // remove the label first

            chart.data.datasets.forEach(dataset => {
                dataset.data.pop();
            });

            chart.update();
        }
    }
];
</script>

</html>
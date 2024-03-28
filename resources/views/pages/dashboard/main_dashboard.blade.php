@extends('layout.main_layout')

@section('content')
<div class="col-sm-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Data Prodi Mahasiswa</h4>
            </div>
        </div>
        <div class="card-body">
            <div id="mhs-prodi-pie-chart"></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
           <div class="header-title">
              <h4 class="card-title">Data Jumlah Mahasiswa</h4>
           </div>
        </div>
        <div class="card-body">
           <div id="mhs-total-line-chart"></div>
        </div>
     </div>
</div>
<div class="col-sm-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Data Mahasiswa</h4>
            </div>
        </div>
        <div class="card-body">
            <div id="mhs-kelamin-bar-chart"></div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/apexcharts.js') }}"></script>
<script>
    function setGrapikProdiMahasiswa(){
        // Inisialisasi data untuk chart
        let prodiData = {};

        // Kelompokkan data mahasiswa berdasarkan mhs_prodi_id
        @foreach($data_mahasiswa as $row_mahasiswa)
            prodiNama = "{{ $row_mahasiswa->prodi_nama }}";
            prodiData[prodiNama] = (prodiData[prodiNama] || 0) + 1;
        @endforeach

        // console.log(prodiData)

        // Persiapkan label dan nilai untuk chart
        let labels = [];
        let series = [];
        for (let prodiNama in prodiData) {
            labels.push("Prodi " + prodiNama);
            series.push(prodiData[prodiNama]);
        }

        // Atur opsi chart
        let options = {
            chart: {
                width: 380,
                type: "pie"
            },
            labels: labels,
            series: series,
            colors: [
                "#4788ff", // Biru
                "#ff4b4b", // Merah
                "#876cfe", // Ungu
                "#37e6b0", // Hijau
                "#c8c8c8", // Abu-abu
                "#ffbb00", // Kuning
                "#ff6384", // Merah muda
                "#36a2eb", // Biru muda
                "#4bc0c0", // Cyan
                "#ffcd56", // Oranye muda
                "#9966ff", // Ungu muda
                "#ff9f40"  // Oranye
            ],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: "bottom"
                    }
                }
            }]
        };

        // Render chart
        if (jQuery("#mhs-prodi-pie-chart").length) {
            let chart = new ApexCharts(document.querySelector("#mhs-prodi-pie-chart"), options);
            chart.render();
        }
    }

    function setGrapikKelaminMahasiswa() {

        // Olah array berdasarkan data di DashboardController
        let prodiNames = [];
        let prodiCountPria = [];
        let prodiCountWanita = [];
        // Loop melalui data program studi dan tambahkan nama program studi ke array
        {!! $data_prodi->toJson() !!}.forEach(function (data) {
            prodiNames.push(data.prodi_nama);
        });

        {!! $data_mahasiswa_group_prodi->toJson() !!}.forEach(function (data) {
            prodiCountPria.push(data.mhs_count_kelamin_pria);
            prodiCountWanita.push(data.mhs_count_kelamin_wanita);
        });


        // console.log({!! $data_mahasiswa_group_prodi->toJson() !!});
        // console.log(prodiNames);
        // console.log(prodiCountPria);
        // console.log(prodiCountWanita);

        if (jQuery("#mhs-kelamin-bar-chart").length) {
            options = {
                chart: {
                    height: 350,
                    type: "bar"
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "55%",
                        endingShape: "rounded"
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ["transparent"]
                },
                colors: ["#4788ff", "#ff4b4b"],
                series: [{
                    name: "Laki-Laki",
                    data: prodiCountPria
                }, {
                    name: "Perempuan",
                    data: prodiCountWanita
                }],
                xaxis: {
                    categories: prodiNames
                },
                yaxis: {
                    title: {
                        text: "Jumlah Mahasiswa"
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (e) {
                            return e + " Mahasiswa"
                        }
                    }
                }
            };
            (chart = new ApexCharts(document.querySelector("#mhs-kelamin-bar-chart"), options)).render()
            const body = document.querySelector('body')
            if (body.classList.contains('dark')) {
                apexChartUpdate(chart, {
                    dark: true
                })
            }

            document.addEventListener('ChangeColorMode', function (e) {
                apexChartUpdate(chart, e.detail)
            })
        }
    }

    function setGrapikTotalMahasiswa() {
        // Olah array berdasarkan data di DashboardController
        let prodiLineNames = [];
        let prodiLineCounts = [];
        let count_all = 0;
        // Loop melalui data program studi dan tambahkan nama program studi ke array
        {!! $data_prodi->toJson() !!}.forEach(function (data) {
            prodiLineNames.push(data.prodi_nama);
        });

        {!! $data_mahasiswa_group_prodi->toJson() !!}.forEach(function (data) {
            prodiLineCounts.push(parseInt(data.mhs_count_kelamin_pria) + parseInt(data.mhs_count_kelamin_wanita));
            count_all += parseInt(data.mhs_count_kelamin_pria) + parseInt(data.mhs_count_kelamin_wanita);
        });

        console.log(prodiLineCounts)

        if (jQuery("#mhs-total-line-chart").length) {
            options = {
                chart: {
                    height: 350,
                    type: "line",
                    zoom: {
                        enabled: false
                    }
                },
                colors: ["#4788ff"],
                series: [{
                    name: "Jumlah Mahasiswa",
                    data: prodiLineCounts
                }],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: "straight"
                },
                title: {
                    text: "Jumlah Mahasiswa " + count_all,
                    align: "left"
                },
                grid: {
                    row: {
                        colors: ["#f3f3f3", "transparent"],
                        opacity: 1
                    }
                },
                xaxis: {
                    categories: prodiLineNames
                }
            };

            if (typeof ApexCharts !== "undefined") {
                (chart = new ApexCharts(document.querySelector("#mhs-total-line-chart"), options)).render();
                const body = document.querySelector('body');
                if (body.classList.contains('dark')) {
                    apexChartUpdate(chart, { dark: true });
                }

                document.addEventListener('ChangeColorMode', function (e) {
                    apexChartUpdate(chart, e.detail);
                });
            }
        }
    }

    setGrapikProdiMahasiswa();
    setGrapikKelaminMahasiswa();
    setGrapikTotalMahasiswa();
</script>
@endsection

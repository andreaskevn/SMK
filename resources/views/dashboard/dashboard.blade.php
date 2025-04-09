@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <x-dashboard-card title="Total Siswa" :value="$totalSiswa" icon="👨‍🎓" />
            <x-dashboard-card title="Total Guru" :value="$totalGuru" icon="👨‍🏫" />
            <x-dashboard-card title="Total Kelas" :value="$totalKelas" icon="🏫" />
        </div>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-md">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Distribusi Siswa & Guru per Kelas</h2>
                <canvas id="kelasChart" height="150"></canvas>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-md">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Top 5 Kelas dengan Jumlah Siswa</h2>
                <canvas id="pieChart" width="100" height="100"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Data dari controller
        const labels = @json($labels);
        const siswaData = @json($siswaData);
        const guruData = @json($guruData);

        // Chart Bar
        new Chart(document.getElementById('kelasChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Siswa',
                        data: siswaData,
                        backgroundColor: '#3B82F6'
                    },
                    {
                        label: 'Guru',
                        data: guruData,
                        backgroundColor: '#F59E0B'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Doughnut Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: siswaData,
                    backgroundColor: [
                        '#3B82F6', '#F59E0B', '#10B981',
                        '#EF4444', '#8B5CF6'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection

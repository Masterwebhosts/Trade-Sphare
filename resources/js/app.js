import './bootstrap';

import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {

    const el = document.querySelector('#financial-chart');

    if (!el || !window.financialChart) {
        return;
    }

    const data = window.financialChart;

    const chart = new ApexCharts(el, {

        chart: {
            type: 'line',
            height: 350,
            toolbar: {
                show: false,
            },
        },

        stroke: {
            curve: 'smooth',
            width: 3,
        },

        series: [
            {
                name: 'Revenue',
                data: data.map(i => i.revenue),
            },

            {
                name: 'Payouts',
                data: data.map(i => i.payouts),
            },

            {
                name: 'Profit',
                data: data.map(i => i.profit),
            }
        ],

        xaxis: {
            categories: data.map(i => i.date),
        },

        yaxis: {
            labels: {
                formatter: value => '$' + value,
            }
        },

        tooltip: {
            y: {
                formatter: value => '$' + value,
            }
        }
    });

    chart.render();
});

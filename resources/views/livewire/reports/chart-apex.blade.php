<div x-data="{
    values: [45, 55, 75, 25, 45, 110],
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June'],
    init() {
        let chart = new ApexCharts(this.$refs.chart, this.options)

        chart.render()

        this.$watch('values', () => {
            chart.updateOptions(this.options)
        })
    },
    get options() {
        return {
            chart: { type: 'bar', toolbar: true, width: 600 },
            legend: {
                position: 'right',
                offsetY: 150
            },
            plotOptions: {
              bar: {
                horizontal: true,
                dataLabels: {
                  position: 'top',
                },
              },
            },
            tooltip: {
                marker: false,
                y: {
                    formatter(number) {
                        return '$'+number
                    }
                }
            },
            xaxis: { categories: this.labels },
            series: [{ data : this.values, name: 'blue' }, { data : [56, 76, 34, 64, 89, 54], name: 'green' }],
        }
    }
}">
    <div x-ref="chart"></div>
</div>

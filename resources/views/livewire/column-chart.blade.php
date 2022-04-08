<div x-data="{
    init() {
        let chart = new ApexCharts(this.$refs.chart, this.options)

        chart.render()

        this.$watch('values', () => {
            chart.updateOptions(this.options)
        })
    },
    get options() {
        return {{ $options }}
    }
}">
    <div x-ref='chart'></div>
</div>

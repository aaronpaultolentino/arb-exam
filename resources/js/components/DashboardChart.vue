<template>
  <div class="container">
    <line-chart
      v-if="loaded"
      :chartdata="chartdata"
      :options="options"/>
  </div>
</template>

<script>
import LineChart from './Chart.vue'

export default {
  name: 'LineChartContainer',
  components: { LineChart },
  data: () => ({
    loaded: false,
    chartdata: null
  }),
  async mounted () {
  	self = this;
    this.loaded = false
    try {
      	axios.get('/expenses/chart').then(function (res) {
      		console.log(res.data)
      		self.chartdata = res.data
		    self.options = {
			        scales: {
			            y: {
			                beginAtZero: true
			            }
			        }
			    }
		    self.loaded = true
	   	}.bind(this));
      
    } catch (e) {
      console.error(e)
    }
  }
}
</script>
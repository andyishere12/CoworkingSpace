 <!-- Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2025 <a href="#">Trackingspace</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>
</div>

  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
  <!-- AdminLTE App -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

  <script>
    // Weekly Visit Pattern Chart
    const weeklyCtx = document.getElementById('weekly-chart').getContext('2d');
    new Chart(weeklyCtx, {
      type: 'line',
      data: {
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        datasets: [
          {
            label: 'Current Week',
            data: [15, 11, 6, 8, 4, 0],
            borderColor: '#00BCD4',
            backgroundColor: 'rgba(0, 188, 212, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#00BCD4'
          },
          {
            label: 'Last Week',
            data: [17, 19, 12, 15, 11, 0],
            borderColor: '#E0E0E0',
            backgroundColor: 'rgba(224, 224, 224, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#E0E0E0'
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true,
            position: 'bottom'
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Number of Visits'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Days'
            }
          }
        }
      }
    });

    // Activity Distribution Donut Chart
    const donutCtx = document.getElementById('donut-chart').getContext('2d');
    new Chart(donutCtx, {
      type: 'doughnut',
      data: {
        labels: ['Student: 70.2%', 'Worker: 13.0%', 'Freelance: 10.1%', 'Business: 5.3%', 'Community: 1.4%'],
        datasets: [{
          data: [70.2, 13.0, 10.1, 5.3, 1.4],
          backgroundColor: ['#E74C3C', '#27AE60', '#3498DB', '#F39C12', '#9B59B6'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true,
            position: 'right',
            labels: {
              boxWidth: 15,
              padding: 15
            }
          }
        },
        cutout: '65%'
      }
    });

    // Monthly Visits Bar Chart
    const barCtx = document.getElementById('bar-chart').getContext('2d');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
          label: 'Visits',
          data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 194, 38],
          backgroundColor: ['#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#5C7CFA', '#4ECDC4'],
          borderRadius: 5
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 250,
            ticks: {
              stepSize: 50
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  </script>
</body>

</html>
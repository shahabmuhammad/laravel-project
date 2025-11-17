
document.addEventListener('DOMContentLoaded', function(){
  // Bar chart
  const barCtx = document.getElementById('barChart').getContext('2d');
  new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul'],
      datasets: [{ data: [60,85,80,90,110,75,60], borderRadius:6, barThickness:18, backgroundColor:'#066187' }]
    },
    options: {
      responsive:true, maintainAspectRatio:false,
      plugins:{ legend:{display:false} },
      scales: {
        x:{ grid:{display:false}, ticks:{color:'#6c757d'} },
        y:{ grid:{color:'#f0f2f5'}, beginAtZero:true, ticks:{stepSize:20, color:'#6c757d'} }
      }
    }
  });

  // Donut chart
  const donutCtx = document.getElementById('donutChart').getContext('2d');
  new Chart(donutCtx, {
    type:'doughnut',
    data:{ labels:['Information Technology','Medicine','Environmental Science'], datasets:[{data:[45,35,20], backgroundColor:['#2e7bd6','#1fb48a','#f4a261']}] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}} }
  });

  // Toggle sidebar on mobile
  const toggleBtn = document.getElementById('menu-toggle');
  if(toggleBtn){
    toggleBtn.addEventListener('click', function(e){
      e.preventDefault();
      document.getElementById('sidebar').classList.toggle('d-none');
    });
  }
});

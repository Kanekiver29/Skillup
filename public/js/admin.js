document.addEventListener('DOMContentLoaded', () => {
  // Staggered sidebar links slide-in
  const links = document.querySelectorAll('.sidebar .admin-sidebar-link');
  links.forEach((el, i) => setTimeout(() => el.classList.add('show'), 90 * i));

  // Cards fade-up in sequence
  const cards = document.querySelectorAll('.card');
  cards.forEach((c, i) => setTimeout(() => c.classList.add('show'), 120 + i * 80));

  // Table rows stagger
  const rows = document.querySelectorAll('table tbody tr');
  rows.forEach((r, i) => setTimeout(() => r.classList.add('show'), 100 + i * 60));

  // Stat counters
  function animateCount(el, to, duration=1000){
    const start = 0; const startTime = performance.now();
    requestAnimationFrame(function tick(now){
      const t = Math.min(1, (now - startTime) / duration);
      const eased = t*(2-t); // easeOutQuad
      el.textContent = Math.floor(eased * (to - start) + start).toLocaleString();
      if(t < 1) requestAnimationFrame(tick);
    });
  }
  document.querySelectorAll('[data-count]').forEach(el => {
    const to = parseInt(el.getAttribute('data-count'),10) || 0;
    setTimeout(()=> animateCount(el, to, 1100), 300);
  });

  // Progress bars fill with spring-like easing
  document.querySelectorAll('.progress-bar').forEach((bar, i) => {
    const target = bar.getAttribute('data-target') || '0%';
    setTimeout(()=> { bar.style.width = target; }, 400 + i*120);
  });

  // Initialize Chart.js charts if present
  function initCharts(){
    if(typeof Chart === 'undefined') return;
    document.querySelectorAll('canvas.chart').forEach((canvas)=>{
      const type = canvas.dataset.type || 'doughnut';
      if(type === 'doughnut'){
        const data = JSON.parse(canvas.dataset.values || '[30,40,30]');
        new Chart(canvas.getContext('2d'),{
          type: 'doughnut',
          data: { labels: JSON.parse(canvas.dataset.labels||'["A","B","C"]'), datasets:[{data,backgroundColor:['#06b6d4','#7c3aed','#f59e0b'],borderWidth:0}]},
          options:{animation:{animateRotate:true, duration:900, easing:'easeOutCubic'}, plugins:{legend:{display:false}}}
        });
      } else if(type === 'bar'){
        const labels = JSON.parse(canvas.dataset.labels||'["Jan","Feb","Mar"]');
        const values = JSON.parse(canvas.dataset.values||'[30,50,40]');
        new Chart(canvas.getContext('2d'),{
          type:'bar',
          data:{labels, datasets:[{data:values, backgroundColor:labels.map((_,i)=>['#06b6d4','#7c3aed','#f59e0b'][i%3]), borderRadius:6}]},
          options:{animation:{duration:900,delay: (ctx)=> ctx.dataIndex*120}, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}}}
        });
      }
    });
  }

  // Try init charts now; if Chart.js loads later, poll briefly
  initCharts();
  let ctries = 0; const ci = setInterval(()=>{ ctries++; initCharts(); if(ctries>8) clearInterval(ci); }, 300);

  // Poll admin chat notifications endpoint and update unread badge
  const notifMeta = document.querySelector('meta[name="admin-chats-notifications"]');
  const unreadBadge = document.getElementById('admin-unread-badge');
  if(notifMeta && unreadBadge){
    const url = notifMeta.getAttribute('content');
    async function fetchUnread(){
      try{
        const res = await fetch(url, { method: 'GET', credentials: 'same-origin', headers: { 'Accept': 'application/json' } });
        if(!res.ok) return;
        const data = await res.json();
        const n = parseInt(data.unread || 0, 10);
        if(n > 0){
          unreadBadge.textContent = n > 99 ? '99+' : String(n);
          unreadBadge.classList.remove('hidden');
        } else {
          unreadBadge.classList.add('hidden');
        }
      }catch(e){
        console.debug('Failed fetching admin notifications', e);
      }
    }

    // Initial fetch and polling every 10s
    fetchUnread();
    setInterval(fetchUnread, 10000);
  }
});

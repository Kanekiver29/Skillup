window.LMS = (function(){
  const uid = ()=>Math.random().toString(36).slice(2,9);

  // Persistence helpers
  function saveStore(s){ try{ localStorage.setItem('lms_store', JSON.stringify(s)); }catch(e){ console.warn('Save failed',e); } }
  function loadStore(){ try{ const raw = localStorage.getItem('lms_store'); return raw?JSON.parse(raw):null; }catch(e){ return null; } }

  // initial store (merge with persisted)
  const defaultStore = {
    courses: [
      {id:'c1', title:'Intro to JS', status:'Active', students:3, analytics:{completionRate:0.6,timeSpent:120,activeStudents:2,quizScores:[80,90]}, modules:[{id:'m1',title:'Welcome',type:'Lesson',duration:5,content:'<p>Welcome</p>',attachments:[]},{id:'m2',title:'JS Basics',type:'Video',duration:12,content:'<p>Video lesson</p>',attachments:[]}]},
      {id:'c2', title:'Advanced CSS', status:'Draft', students:1, analytics:{completionRate:0.0,timeSpent:0,activeStudents:0,quizScores:[]}, modules:[]}
    ]
  };

  const persisted = loadStore();
  const store = persisted || defaultStore;

  function persist(){ saveStore(store); }

  function addCourse(opts){
    const c={id:uid(),title:opts.title||'Untitled',status:opts.status||'Draft',students:0,analytics:{completionRate:0,timeSpent:0,activeStudents:0,quizScores:[]},modules:[]};
    store.courses.unshift(c); persist(); return c;
  }

  function getCourse(id){ return store.courses.find(c=>c.id==id); }

  function computeAnalytics(course){
    // simple derivation for demo: completion = average of module.completed flags (if present)
    const modules = course.modules || [];
    const completed = modules.filter(m=>m.completed).length;
    const completionRate = modules.length?+(completed/modules.length).toFixed(2):0;
    const timeSpent = course.analytics && course.analytics.timeSpent? course.analytics.timeSpent : 0;
    const activeStudents = course.analytics && course.analytics.activeStudents? course.analytics.activeStudents : 0;
    const avgQuiz = (course.analytics && course.analytics.quizScores && course.analytics.quizScores.length)? Math.round(course.analytics.quizScores.reduce((a,b)=>a+b,0)/course.analytics.quizScores.length):0;
    return {completionRate,timeSpent,activeStudents,avgQuiz};
  }

  function renderDashboard(){
    const el=document.getElementById('coursesList'); if(!el) return;
    el.innerHTML='';
    store.courses.forEach(c=>{
      const a = computeAnalytics(c);
      const card=document.createElement('article'); card.className='card';
      card.innerHTML=`<h3>${c.title}</h3><div class="badges"><span class="status">${c.status}</span></div><p>${c.modules.length} modules • ${c.students} students</p><p class="muted">Completion: ${Math.round(a.completionRate*100)}% • Avg quiz: ${a.avgQuiz}% • Time: ${a.timeSpent}m</p>`;
      card.addEventListener('click',()=> location.href='/staff/course/'+c.id);
      el.appendChild(card);
    });
  }

  /* Editor */
  function openEditor(id){
    const course = getCourse(id);
    if(!course) return;
    document.getElementById('courseTitle').textContent = course.title;
    renderModules(course);
    setupEditorActions(course);
    renderAnalyticsPanel(course);
  }

  function renderModules(course){
    const list=document.getElementById('modulesList'); if(!list) return;
    list.innerHTML='';
    course.modules.forEach(m=>{
      const li=document.createElement('li'); li.className='module-item'; li.draggable=true; li.dataset.id=m.id;
      const qcount = (m.questions && m.questions.length)? ` • ${m.questions.length} Qs` : '';
      li.innerHTML=`<span class="grip" aria-hidden="true">☰</span><strong>${m.title}</strong><small>${m.type}${qcount} • ${m.duration||0}m</small>`;
      li.addEventListener('click',()=> loadModuleToEditor(course,m.id));
      li.addEventListener('dragstart', dragStart);
      li.addEventListener('dragover', dragOver);
      li.addEventListener('drop', (e)=> drop(e,course));
      list.appendChild(li);
    });
  }

  let currentModuleId=null;
  function loadModuleToEditor(course,moduleId){
    const m = course.modules.find(x=>x.id==moduleId); if(!m) return;
    currentModuleId = m.id;
    document.getElementById('moduleTitle').value = m.title;
    document.getElementById('moduleType').value = m.type;
    document.getElementById('moduleDuration').value = m.duration||'';
    document.getElementById('contentEditor').innerHTML = m.content||'';
    document.getElementById('studentsView').innerHTML = renderStudents(course);
    // attachments
    const attachList = document.getElementById('attachmentsList'); if(attachList){ attachList.innerHTML=''; (m.attachments||[]).forEach(a=>{ const li=document.createElement('div'); if(a.type==='youtube' || a.url){ const vid = extractYouTubeID(a.url||a.dataUrl||''); if(vid){ li.innerHTML = `<div class="yt"><iframe width="260" height="146" src="https://www.youtube.com/embed/${vid}" title="YouTube video" frameborder="0" allowfullscreen></iframe></div>`; } else { li.innerHTML = `<a href="${a.url||a.dataUrl}" target="_blank">${a.name||'link'}</a>`; } } else { li.innerHTML=`<a href="${a.dataUrl||a.url}" target="_blank">${a.name}</a>`; } attachList.appendChild(li); }); }
    // quiz questions
    if(m.questions){ renderQuizBuilder(m); }
  }

  function renderStudents(course){
    const a = computeAnalytics(course);
    return `<h3>Students (${course.students})</h3><ul><li>Completion: ${Math.round(a.completionRate*100)}%</li><li>Avg quiz: ${a.avgQuiz}%</li><li>Time spent: ${a.timeSpent}m</li><li>Active: ${a.activeStudents}</li></ul>`;
  }

  function renderAnalyticsPanel(course){
    const el = document.getElementById('analyticsPanel'); if(!el) return;
    const a = computeAnalytics(course);
    el.innerHTML = `<h3>Course Analytics</h3><p>Completion rate: <strong>${Math.round(a.completionRate*100)}%</strong></p><p>Avg quiz score: <strong>${a.avgQuiz}%</strong></p><p>Time spent: <strong>${a.timeSpent} minutes</strong></p><p>Active students: <strong>${a.activeStudents}</strong></p>`;
  }

  function setupEditorActions(course){
    document.getElementById('addModuleBtn').onclick = ()=>{
      const m={id:uid(),title:'New module',type:'Lesson',duration:5,content:'<p></p>',attachments:[]};
      course.modules.push(m); persist(); renderModules(course); loadModuleToEditor(course,m.id);
    };
    document.getElementById('saveModule').onclick = ()=>{
      const m = course.modules.find(x=>x.id==currentModuleId); if(!m) return;
      m.title=document.getElementById('moduleTitle').value;
      m.type=document.getElementById('moduleType').value;
      m.duration=document.getElementById('moduleDuration').value;
      m.content=document.getElementById('contentEditor').innerHTML;
      persist(); renderModules(course); renderAnalyticsPanel(course); alert('Module saved (persisted to localStorage)');
    };
    document.getElementById('duplicateModule').onclick = ()=>{
      const m = course.modules.find(x=>x.id==currentModuleId); if(!m) return;
      const copy = JSON.parse(JSON.stringify(m)); copy.id = uid(); copy.title += ' (copy)'; course.modules.push(copy); persist(); renderModules(course);
    };
    document.getElementById('deleteModule').onclick = ()=>{
      const idx = course.modules.findIndex(x=>x.id==currentModuleId); if(idx<0) return; if(!confirm('Delete module?')) return;
      course.modules.splice(idx,1); currentModuleId=null; persist(); renderModules(course); document.getElementById('contentEditor').innerHTML='';
    };

    // attachments
    const fileInput = document.getElementById('attachmentInput'); if(fileInput){ fileInput.onchange = function(e){ const f = e.target.files[0]; if(!f) return; const reader = new FileReader(); reader.onload = function(){ const module = course.modules.find(x=>x.id==currentModuleId); if(!module) return; module.attachments = module.attachments||[]; module.attachments.push({name:f.name,type:f.type,dataUrl:reader.result}); persist(); loadModuleToEditor(course,currentModuleId); }; reader.readAsDataURL(f); }; }

    const addYoutubeBtn = document.getElementById('addYoutubeBtn'); if(addYoutubeBtn){ addYoutubeBtn.onclick = ()=>{
      const url = document.getElementById('youtubeInput').value.trim(); if(!url) return alert('Paste a YouTube URL');
      const module = course.modules.find(x=>x.id==currentModuleId); if(!module) return;
      module.attachments = module.attachments||[]; module.attachments.push({name:'YouTube',type:'youtube',url:url}); persist(); loadModuleToEditor(course,currentModuleId); document.getElementById('youtubeInput').value='';
    }; }

    // quiz builder actions
    const addQBtn = document.getElementById('addQuestionBtn'); if(addQBtn){ addQBtn.onclick = ()=>{
      const module = course.modules.find(x=>x.id==currentModuleId); if(!module) return; module.questions = module.questions||[]; module.questions.push({id:uid(),question:'New question',options:['Option 1','Option 2'],answer:0}); persist(); renderQuizBuilder(module);
    }; }
    document.getElementById('saveCourseBtn')?.addEventListener('click', ()=>{ persist(); alert('Course saved'); });

    // toolbar
    document.querySelectorAll('.editor-toolbar [data-cmd]').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const cmd = btn.dataset.cmd;
        if(cmd==='createLink'){ const url = prompt('URL'); if(url) document.execCommand('createLink', false, url); }
        else if(cmd==='formatBlock'){ document.execCommand('formatBlock', false, btn.dataset.value); }
        else document.execCommand(cmd, false, null);
      });
    });
  }

  function renderQuizBuilder(module){
    const qb = document.getElementById('quizBuilder'); if(!qb) return; qb.innerHTML='';
    module.questions = module.questions||[];
    module.questions.forEach((q,idx)=>{
      const div = document.createElement('div'); div.className='quiz-q';
      const multiple = q.multiple || false;
      div.innerHTML = `
        <div class="quiz-q-head">
          <button class="q-up">▲</button>
          <button class="q-down">▼</button>
          <input class="q-text" value="${escapeHtml(q.question)}" placeholder="Question text">
          <input class="q-points" type="number" value="${q.points||1}" style="width:70px;margin-left:8px" title="points">
          <label style="margin-left:8px"><input type="checkbox" class="q-multiple" ${multiple?'checked':''}> multiple</label>
          <button class="removeQ" style="margin-left:8px">Remove</button>
        </div>
        <div class="opts"></div>
        <div style="margin-top:6px"><button class="addOpt">+ Add Option</button></div>
      `;

      // handlers
      const qText = div.querySelector('.q-text');
      qText.addEventListener('input', ()=>{ q.question = qText.value; persist(); });
      const qPoints = div.querySelector('.q-points'); qPoints.addEventListener('change', ()=>{ q.points = parseInt(qPoints.value||1); persist(); });
      const qMultiple = div.querySelector('.q-multiple'); qMultiple.addEventListener('change', ()=>{ q.multiple = qMultiple.checked; if(!q.multiple && Array.isArray(q.answer)) q.answer = q.answer[0] ?? 0; persist(); renderQuizBuilder(module); });

      const up = div.querySelector('.q-up'); up.addEventListener('click', ()=>{ if(idx>0){ const a = module.questions.splice(idx,1)[0]; module.questions.splice(idx-1,0,a); persist(); renderQuizBuilder(module); }});
      const down = div.querySelector('.q-down'); down.addEventListener('click', ()=>{ if(idx < module.questions.length-1){ const a = module.questions.splice(idx,1)[0]; module.questions.splice(idx+1,0,a); persist(); renderQuizBuilder(module); }});
      const remove = div.querySelector('.removeQ'); remove.addEventListener('click', ()=>{ if(!confirm('Remove question?')) return; module.questions.splice(idx,1); persist(); renderQuizBuilder(module); });

      const opts = div.querySelector('.opts');
      q.options = q.options||[];
      q.options.forEach((opt,i)=>{
        const optEl = document.createElement('div');
        optEl.className = 'opt-row';
        const checked = (Array.isArray(q.answer) ? q.answer.includes(i) : q.answer===i) ? 'checked' : '';
        optEl.innerHTML = `<input class="opt-text" value="${escapeHtml(opt)}"> <label><input type="${q.multiple? 'checkbox':'radio'}" name="ans-${q.id}" ${checked}> correct</label> <button class="opt-up">▲</button> <button class="opt-down">▼</button> <button class="opt-remove">✖</button>`;
        const optText = optEl.querySelector('.opt-text'); optText.addEventListener('input', ()=>{ q.options[i] = optText.value; persist(); });
        const optCorrect = optEl.querySelector('input[type="checkbox"], input[type="radio"]'); optCorrect.addEventListener('change', ()=>{
          if(q.multiple){ q.answer = q.answer||[]; if(optCorrect.checked){ if(!q.answer.includes(i)) q.answer.push(i); } else { q.answer = q.answer.filter(x=>x!==i); } }
          else { q.answer = i; // uncheck others handled by radio
          }
          persist(); renderQuizBuilder(module);
        });
        const optUp = optEl.querySelector('.opt-up'); optUp.addEventListener('click', ()=>{ if(i>0){ const it = q.options.splice(i,1)[0]; q.options.splice(i-1,0,it); // adjust answers
          if(Array.isArray(q.answer)){ q.answer = q.answer.map(a=> a===i? i-1 : a===i-1? i : a); }
          else if(q.answer===i) q.answer = i-1; else if(q.answer===i-1) q.answer = i; persist(); renderQuizBuilder(module);} });
        const optDown = optEl.querySelector('.opt-down'); optDown.addEventListener('click', ()=>{ if(i<q.options.length-1){ const it = q.options.splice(i,1)[0]; q.options.splice(i+1,0,it); if(Array.isArray(q.answer)){ q.answer = q.answer.map(a=> a===i? i+1 : a===i+1? i : a); } else if(q.answer===i) q.answer = i+1; else if(q.answer===i+1) q.answer = i; persist(); renderQuizBuilder(module);} });
        const optRemove = optEl.querySelector('.opt-remove'); optRemove.addEventListener('click', ()=>{ q.options.splice(i,1); if(Array.isArray(q.answer)) q.answer = q.answer.filter(x=>x!==i); else if(q.answer===i) q.answer = 0; persist(); renderQuizBuilder(module); });
        opts.appendChild(optEl);
      });

      const addOpt = div.querySelector('.addOpt'); addOpt.addEventListener('click', ()=>{ q.options.push('New option'); persist(); renderQuizBuilder(module); });

      qb.appendChild(div);
    });
  }

  function escapeHtml(s){ return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

  function extractYouTubeID(url){ if(!url) return null; const m = url.match(/[?&]v=([^&]+)/) || url.match(/youtu\.be\/([^?&]+)/) || url.match(/embed\/([^?&]+)/); return m?m[1]:null; }

  /* drag/drop helpers */
  let dragId=null;
  function dragStart(e){ dragId = e.currentTarget.dataset.id; e.dataTransfer.effectAllowed='move'; }
  function dragOver(e){ e.preventDefault(); e.dataTransfer.dropEffect='move'; }
  function drop(e,course){ e.preventDefault(); const toId = e.currentTarget.dataset.id; if(!dragId||!toId) return;
    const fromIdx = course.modules.findIndex(m=>m.id==dragId);
    const toIdx = course.modules.findIndex(m=>m.id==toId);
    if(fromIdx<0||toIdx<0) return;
    const [item] = course.modules.splice(fromIdx,1);
    course.modules.splice(toIdx,0,item);
    persist(); renderModules(course);
  }

  // Expose some helpers for testing
  function exportToBackend(){
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const headers = { 'Content-Type': 'application/json' };
    if (tokenMeta) headers['X-CSRF-TOKEN'] = tokenMeta.getAttribute('content');

    return fetch('/staff/api/sync', {
      method: 'POST',
      headers,
      body: JSON.stringify({ store }),
      credentials: 'same-origin',
    }).then(r=>{
      if(!r.ok) throw r;
      return r.json();
    }).then(json=>{
      alert('Synced to backend: ' + (json.saved_course_ids||[]).length + ' courses');
      // Apply mapping: save DB ids into local store for stable subsequent syncs
      if (json.mapping) {
        const map = json.mapping;
        // courses mapping: local->db
        for (const localId in map.courses) {
          const dbId = map.courses[localId];
          const course = store.courses.find(c=>c.id == localId);
          if (course) course._dbId = dbId;
        }
        // modules mapping: local->db
        for (const localId in map.modules) {
          const dbId = map.modules[localId];
          // find module by local id across courses
          store.courses.forEach(c=>{
            const m = (c.modules||[]).find(x=>x.id == localId);
            if (m) m._dbId = dbId;
          });
        }
        // quizzes mapping stored on module key
        for (const localKey in map.quizzes) {
          const dbId = map.quizzes[localKey];
          // localKey is module local id
          store.courses.forEach(c=>{
            const mod = (c.modules||[]).find(x=>x.id == localKey);
            if (mod) mod._quizDbId = dbId;
          });
        }
        // questions mapping
        for (const localQ in map.questions) {
          const dbId = map.questions[localQ];
          store.courses.forEach(c=>{
            (c.modules||[]).forEach(m=>{
              (m.questions||[]).forEach(q=>{ if(q.id == localQ) q._dbId = dbId; });
            });
          });
        }
        persist();
      }
      return json;
    }).catch(err=>{
      console.error('Sync failed', err);
      alert('Sync failed. Make sure you are logged in with staff access.');
    });
  }

  // auto-save on unload
  window.addEventListener('beforeunload', ()=> persist());

  return { addCourse, renderDashboard, openEditor, store, persist, exportToBackend, computeAnalytics };
})();

function renderDashboard(){ window.LMS.renderDashboard(); }

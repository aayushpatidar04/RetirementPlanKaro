{{--
  Backend for the existing WhatsApp / Email popup (no markup, nothing visible):
  - rpkTplSave / rpkTplNew save templates to Messages & Email → Templates
  - rpkLog records every send (Messages & Email → Activity and the client's Messages tab);
    email is sent from the server through the SMTP mailer
--}}
@push('scripts')
  <script>
    (function () {
      const URL_SEND = @json(route('admin.messages.send'));
      const URL_STORE = @json(route('admin.messages.templates.store'));
      const URL_UPDATE = @json(route('admin.messages.templates.update', '__ID__'));
      const token = () => (document.querySelector('meta[name=csrf-token]') || {}).content || @json(csrf_token());
      async function post(url, data) {
        const res = await fetch(url, {
          method: 'POST', credentials: 'same-origin',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': token() },
          body: JSON.stringify(data)
        });
        let j = {}; try { j = await res.json(); } catch (e) {}
        if (!res.ok) throw new Error(j.errors ? Object.values(j.errors)[0][0] : (j.message || 'Something went wrong'));
        return j;
      }
      window.rpkTplNew = async function (t) {
        try {
          const j = await post(URL_STORE, { name: t.n, channel: t.ch === 'em' ? 'em' : 'wa', subject: t.ch === 'em' ? (t.sub || t.n) : null, body: t.t || 'Hi {name},' });
          t.id = j.template.id;
        } catch (e) { alert('Template could not be created: ' + e.message); }
      };
      window.rpkTplSave = async function (t) {
        try {
          if (!t.id) { await window.rpkTplNew(t); }
          else { await post(URL_UPDATE.replace('__ID__', t.id), { _method: 'PUT', name: t.n, subject: t.sub || null, body: t.t }); }
          alert('Template saved');
        } catch (e) { alert('Template could not be saved: ' + e.message); }
      };
      window.rpkLog = async function (ch, U, body, t, subject) {
        const email = ch === 'em';
        try {
          const j = await post(URL_SEND, {
            channel: ch, deliver: email, subject: email ? (subject || 'Retirement Plan Karo') : (t ? t.n : 'WhatsApp message'),
            body: body, template_id: t && t.id ? t.id : null,
            recipients: [{ user_id: U.userId || null, mobile: (U.mobile || '').replace(/\D/g, '').slice(-10) || null, email: U.email || null, name: U.name || null }]
          });
          if (email) alert(j.failed ? 'Email could not be sent. Please check the mail settings.' : 'Email sent to ' + U.email);
        } catch (e) { if (email) alert('Email could not be sent: ' + e.message); }
      };
    })();
  </script>
@endpush

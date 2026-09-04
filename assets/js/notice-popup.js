/* SRT X DEV — New Store Notice controller */
(function () {
  'use strict';

  function initNotice() {
    const notice = document.getElementById('srtNewStoreNotice');
    if (!notice) return;

    const KEY = 'srt_new_store_notice_seen_v1';
    const SESSION_ONLY = false;
    const SHOW_EVERY_MS = 24 * 60 * 60 * 1000;

    const close = () => {
      notice.classList.remove('is-open');
      notice.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('srt-notice-open');
      if (SESSION_ONLY) {
        sessionStorage.setItem(KEY, '1');
      } else {
        localStorage.setItem(KEY, String(Date.now()));
      }
    };

    notice.querySelectorAll('[data-srt-close]').forEach(btn => {
      btn.addEventListener('click', close);
    });

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && notice.classList.contains('is-open')) close();
    });

    function shouldShow() {
      if (SESSION_ONLY) return !sessionStorage.getItem(KEY);
      const seen = Number(localStorage.getItem(KEY) || 0);
      return !seen || (Date.now() - seen) > SHOW_EVERY_MS;
    }

    // Show after the page has rendered so it doesn't interfere with page boot/auth.
    if (shouldShow()) {
      window.setTimeout(() => {
        notice.classList.add('is-open');
        notice.setAttribute('aria-hidden', 'false');
        document.body.classList.add('srt-notice-open');
      }, 450);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNotice);
  } else {
    initNotice();
  }
})();

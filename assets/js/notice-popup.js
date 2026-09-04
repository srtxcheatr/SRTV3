/**
 * =========================================================
 * SRT X CHEATS
 * NEW STORE ANNOUNCEMENT POPUP
 * =========================================================
 */

(function () {

    'use strict';

    const STORAGE_KEY = 'srt_new_store_notice';

    // Show again after 24 hours
    const SHOW_INTERVAL = 24 * 60 * 60 * 1000;


    function getElement(id) {
        return document.getElementById(id);
    }


    function shouldShowNotice() {

        try {

            const lastShown =
                localStorage.getItem(STORAGE_KEY);

            if (!lastShown) {
                return true;
            }

            const elapsed =
                Date.now() - Number(lastShown);

            return elapsed >= SHOW_INTERVAL;

        } catch (error) {

            // If localStorage is unavailable,
            // allow the popup to appear.
            return true;
        }
    }


    function markNoticeShown() {

        try {

            localStorage.setItem(
                STORAGE_KEY,
                String(Date.now())
            );

        } catch (error) {

            // Ignore storage errors.
        }
    }


    function openNotice() {

        const overlay =
            getElement('srtNoticeOverlay');

        if (!overlay) {
            return;
        }

        overlay.classList.add(
            'srt-notice-show'
        );

        overlay.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.classList.add(
            'srt-notice-open'
        );
    }


    function closeNotice(saveState = true) {

        const overlay =
            getElement('srtNoticeOverlay');

        if (!overlay) {
            return;
        }

        overlay.classList.remove(
            'srt-notice-show'
        );

        overlay.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.classList.remove(
            'srt-notice-open'
        );

        if (saveState) {
            markNoticeShown();
        }
    }


    function initNotice() {

        const overlay =
            getElement('srtNoticeOverlay');

        const closeButton =
            getElement('srtNoticeClose');

        const continueButton =
            getElement('srtNoticeContinue');

        if (!overlay) {
            return;
        }


        /*
         * Close button
         */
        if (closeButton) {

            closeButton.addEventListener(
                'click',
                function () {

                    closeNotice(true);

                }
            );

        }


        /*
         * Continue to old store
         */
        if (continueButton) {

            continueButton.addEventListener(
                'click',
                function () {

                    closeNotice(true);

                }
            );

        }


        /*
         * Clicking the dark background closes popup.
         */
        overlay.addEventListener(
            'click',
            function (event) {

                if (event.target === overlay) {

                    closeNotice(true);

                }

            }
        );


        /*
         * ESC key closes popup.
         */
        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Escape' &&
                    overlay.classList.contains(
                        'srt-notice-show'
                    )
                ) {

                    closeNotice(true);

                }

            }
        );


        /*
         * Prevent page scrolling while popup is open.
         */
        const style =
            document.createElement('style');

        style.textContent = `
            body.srt-notice-open {
                overflow: hidden !important;
            }
        `;

        document.head.appendChild(style);


        /*
         * Show popup after a short delay.
         */
        if (shouldShowNotice()) {

            setTimeout(
                function () {

                    openNotice();

                },
                500
            );

        }

    }


    /*
     * Start after DOM is ready.
     */
    if (
        document.readyState === 'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initNotice
        );

    } else {

        initNotice();

    }


    /*
     * Optional global controls.
     * Useful if another page needs to manually
     * open or close the announcement.
     */

    window.SRTXNotice = {

        open: function () {
            openNotice();
        },

        close: function () {
            closeNotice(false);
        },

        reset: function () {

            try {

                localStorage.removeItem(
                    STORAGE_KEY
                );

            } catch (error) {}

        }

    };

})();
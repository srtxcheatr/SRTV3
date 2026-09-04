/**
 * =========================================================
 * SRT X CHEATS
 * NEW STORE ANNOUNCEMENT POPUP
 * =========================================================
 */

(function () {

    'use strict';

    function getElement(id) {
        return document.getElementById(id);
    }


    function openNotice() {

        const overlay =
            getElement('srtNoticeOverlay');

        if (!overlay) {
            return;
        }

        overlay.classList.add('srt-notice-show');

        overlay.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.classList.add(
            'srt-notice-open'
        );
    }


    function closeNotice() {

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
    }


    function initNotice() {

        const overlay =
            getElement('srtNoticeOverlay');

        const closeButton =
            getElement('srtNoticeClose');

        if (!overlay) {
            return;
        }


        /*
         * CLOSE BUTTON
         */
        if (closeButton) {

            closeButton.addEventListener(
                'click',
                function () {

                    closeNotice();

                }
            );

        }


        /*
         * CLICK OUTSIDE POPUP
         */
        overlay.addEventListener(
            'click',
            function (event) {

                if (event.target === overlay) {

                    closeNotice();

                }

            }
        );


        /*
         * ESC KEY
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

                    closeNotice();

                }

            }
        );


        /*
         * OPEN POPUP
         *
         * Every page load.
         * No localStorage.
         * No cookies.
         * No 24-hour timer.
         */
        setTimeout(
            function () {

                openNotice();

            },
            350
        );

    }


    /*
     * Prevent scrolling while popup is open.
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
     * Initialize.
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
     * Global controls.
     */
    window.SRTXNotice = {

        open: function () {
            openNotice();
        },

        close: function () {
            closeNotice();
        }

    };

})();
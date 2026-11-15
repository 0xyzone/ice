<x-filament-panels::page>
    <div id="manage-profile-form-wrap">
        {{ $this->form }}
    </div>

    <script>
        (function () {
            function initManageProfileTabShuttle() {
                const wrap = document.getElementById('manage-profile-form-wrap');
                if (!wrap) {
                    return;
                }

                const tabs = wrap.querySelector('.fi-tabs');
                if (!tabs || tabs.dataset.shuttleBound === '1') {
                    return;
                }
                tabs.dataset.shuttleBound = '1';

                const shuttle = document.createElement('div');
                shuttle.className = 'fi-tabs-shuttle hidden';
                shuttle.setAttribute('aria-label', 'Slide tabs navigation');
                shuttle.innerHTML = `
                    <button type="button" class="fi-tabs-shuttle-btn" data-dir="-1" aria-label="Scroll tabs left">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5"><path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" /></svg>
                    </button>
                    <div class="fi-tabs-shuttle-track" role="slider" aria-label="Tab scroll position" tabindex="0">
                        <div class="fi-tabs-shuttle-thumb"></div>
                    </div>
                    <button type="button" class="fi-tabs-shuttle-btn" data-dir="1" aria-label="Scroll tabs right">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" /></svg>
                    </button>
                    <span class="fi-tabs-shuttle-hint">Slide</span>
                `;

                tabs.insertAdjacentElement('afterend', shuttle);

                const track = shuttle.querySelector('.fi-tabs-shuttle-track');
                const thumb = shuttle.querySelector('.fi-tabs-shuttle-thumb');
                const buttons = shuttle.querySelectorAll('.fi-tabs-shuttle-btn');

                function syncShuttle() {
                    const maxScroll = tabs.scrollWidth - tabs.clientWidth;
                    if (maxScroll <= 4) {
                        shuttle.classList.add('hidden');
                        return;
                    }
                    shuttle.classList.remove('hidden');

                    const ratio = tabs.clientWidth / tabs.scrollWidth;
                    const thumbPct = Math.max(22, Math.min(85, ratio * 100));
                    const progress = tabs.scrollLeft / maxScroll;
                    const maxLeftPct = 100 - thumbPct;

                    thumb.style.width = thumbPct + '%';
                    thumb.style.left = (progress * maxLeftPct) + '%';

                    buttons[0].disabled = tabs.scrollLeft <= 2;
                    buttons[1].disabled = tabs.scrollLeft >= maxScroll - 2;
                }

                tabs.addEventListener('scroll', syncShuttle, { passive: true });
                window.addEventListener('resize', syncShuttle, { passive: true });
                if (typeof ResizeObserver !== 'undefined') {
                    new ResizeObserver(syncShuttle).observe(tabs);
                }

                buttons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const dir = Number(btn.dataset.dir || 1);
                        tabs.scrollBy({ left: dir * Math.max(140, tabs.clientWidth * 0.55), behavior: 'smooth' });
                    });
                });

                let dragging = false;
                function scrubToClientX(clientX) {
                    const rect = track.getBoundingClientRect();
                    const pct = Math.max(0, Math.min(1, (clientX - rect.left) / rect.width));
                    const maxScroll = tabs.scrollWidth - tabs.clientWidth;
                    tabs.scrollLeft = pct * maxScroll;
                }

                track.addEventListener('pointerdown', (e) => {
                    dragging = true;
                    track.setPointerCapture(e.pointerId);
                    scrubToClientX(e.clientX);
                });
                track.addEventListener('pointermove', (e) => {
                    if (dragging) {
                        scrubToClientX(e.clientX);
                    }
                });
                track.addEventListener('pointerup', () => { dragging = false; });
                track.addEventListener('pointercancel', () => { dragging = false; });

                syncShuttle();
            }

            document.addEventListener('DOMContentLoaded', initManageProfileTabShuttle);
            document.addEventListener('livewire:navigated', initManageProfileTabShuttle);
            setTimeout(initManageProfileTabShuttle, 120);
        })();
    </script>
</x-filament-panels::page>

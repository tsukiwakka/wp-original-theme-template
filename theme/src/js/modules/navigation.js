/**
 * navigation.js
 * ハンバーガーメニュー等のナビゲーション制御
 */

const initNavigation = () => {
  const toggle = document.querySelector('[data-nav-toggle]')
  const menu = document.querySelector('[data-nav-menu]')

  if (!toggle || !menu) return

  toggle.addEventListener('click', () => {
    const isOpen = menu.getAttribute('aria-expanded') === 'true'
    menu.setAttribute('aria-expanded', String(!isOpen))
    toggle.setAttribute('aria-expanded', String(!isOpen))
    menu.classList.toggle('is-open', !isOpen)
  })

  // Escキーで閉じる
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      menu.setAttribute('aria-expanded', 'false')
      toggle.setAttribute('aria-expanded', 'false')
      menu.classList.remove('is-open')
    }
  })
}

document.addEventListener('DOMContentLoaded', initNavigation)

export { initNavigation }

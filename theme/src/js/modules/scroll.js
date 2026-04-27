/**
 * scroll.js
 * スクロール関連の処理
 */

const initScrollEffects = () => {
  // スクロール時のヘッダースタイル変更
  const header = document.querySelector('[data-header]')
  if (header) {
    const onScroll = () => {
      header.classList.toggle('is-scrolled', window.scrollY > 50)
    }
    window.addEventListener('scroll', onScroll, { passive: true })
  }

  // スムーズスクロール（ページ内リンク）
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (e) => {
      const target = document.querySelector(anchor.getAttribute('href'))
      if (target) {
        e.preventDefault()
        target.scrollIntoView({ behavior: 'smooth', block: 'start' })
      }
    })
  })
}

document.addEventListener('DOMContentLoaded', initScrollEffects)

export { initScrollEffects }

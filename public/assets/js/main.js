/* ==========================================================================
   UNIVERSAL SCRIPT TEMPLATE — main.js
   For PHP+MySQL MVC projects using Bootstrap
   Author: Nicolás Servidio
   ========================================================================== */


/*
This JavaScript file is intended to:

- Be fully vanilla JS, no dependencies required  
- Modularize behaviors for forms, modals, dropdowns, collapsibles, carousels, scroll effects, theme switching, and debugging  
- Be audit-friendly, with semantic comments and extensible architecture  
- Be compatible with your PHP+MySQL MVC structure and Bootstrap overrides  
- Include event delegation, accessibility hooks, and performance tracing
*/


/* === Part 1: DOM Ready, Utility Functions, Scroll Effects === */

/* === 1. DOM READY === */

document.addEventListener('DOMContentLoaded', () => {
    initScrollEffects();
    initDropdowns();
    initCollapsibles();
    initThemeSwitcher();
    initModals();
    initFormValidation();
    initCarousel();
    initDebugOverlay();
  });
  
  /* === 2. UTILITY FUNCTIONS === */
  const $ = (selector, scope = document) => scope.querySelector(selector);
  const $$ = (selector, scope = document) => Array.from(scope.querySelectorAll(selector));
  
  const debounce = (fn, delay = 300) => {
    let timeout;
    return (...args) => {
      clearTimeout(timeout);
      timeout = setTimeout(() => fn.apply(this, args), delay);
    };
  };
  
  const throttle = (fn, limit = 300) => {
    let lastCall = 0;
    return (...args) => {
      const now = Date.now();
      if (now - lastCall >= limit) {
        lastCall = now;
        fn.apply(this, args);
      }
    };
  };
  
  /* === 3. SCROLL EFFECTS === */
  function initScrollEffects() {
    const scrollElements = $$('.scroll-fade, .scroll-scale, .scroll-slide-left, .scroll-slide-right');
  
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, {
      threshold: 0.1
    });
  
    scrollElements.forEach(el => observer.observe(el));
  }

  
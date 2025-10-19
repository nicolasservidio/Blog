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

/* ==========================================================================
   UNIVERSAL SCRIPT TEMPLATE — main.js
   For PHP+MySQL MVC projects using Bootstrap
   Author: Nicolás Servidio
   ========================================================================== */

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



/* === Part 2: Dropdowns, Collapsibles, Theme, Modals, Forms === */

/* === 4. DROPDOWNS === */
function initDropdowns() {
  $$('.dropdown-toggle').forEach(toggle => {
    const menu = toggle.nextElementSibling;
    toggle.addEventListener('click', () => {
      menu.classList.toggle('show');
    });

    document.addEventListener('click', (e) => {
      if (!toggle.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove('show');
      }
    });
  });

  // Pure CSS dropdowns (checkbox-based)
  $$('.dropdown-pure input[type="checkbox"]').forEach(input => {
    input.addEventListener('change', () => {
      $$('.dropdown-pure input[type="checkbox"]').forEach(other => {
        if (other !== input) other.checked = false;
      });
    });
  });
}

/* === 5. COLLAPSIBLES === */
function initCollapsibles() {
  $$('.collapsible input[type="checkbox"]').forEach(input => {
    input.addEventListener('change', () => {
      const content = input.parentElement.querySelector('.collapsible-content');
      if (input.checked) {
        content.style.maxHeight = content.scrollHeight + 'px';
      } else {
        content.style.maxHeight = '0';
      }
    });
  });
}

/* === 6. THEME SWITCHER === */
function initThemeSwitcher() {
  const toggle = $('#theme-toggle');
  const root = document.documentElement;

  const applyTheme = (theme) => {
    root.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
  };

  if (toggle) {
    toggle.addEventListener('click', () => {
      const current = root.getAttribute('data-theme') || 'light';
      const next = current === 'light' ? 'dark' : 'light';
      applyTheme(next);
    });
  }

  const savedTheme = localStorage.getItem('theme');
  if (savedTheme) applyTheme(savedTheme);
}

/* === 7. MODALS === */
function initModals() {
  $$('.modal-custom').forEach(modal => {
    const closeBtn = modal.querySelector('.modal-close');
    const backdrop = modal;

    closeBtn?.addEventListener('click', () => {
      backdrop.style.display = 'none';
    });

    backdrop.addEventListener('click', (e) => {
      if (e.target === backdrop) {
        backdrop.style.display = 'none';
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        backdrop.style.display = 'none';
      }
    });
  });

  $$('.modal-trigger').forEach(trigger => {
    const targetId = trigger.getAttribute('data-target');
    const modal = document.getElementById(targetId);
    if (modal) {
      trigger.addEventListener('click', () => {
        modal.style.display = 'flex';
      });
    }
  });
}

/* === 8. FORM VALIDATION === */
function initFormValidation() {
  $$('.form-accessible').forEach(form => {
    form.addEventListener('submit', (e) => {
      let valid = true;
      const inputs = $$('input, textarea, select', form);

      inputs.forEach(input => {
        const error = input.nextElementSibling;
        if (input.hasAttribute('required') && !input.value.trim()) {
          input.classList.add('is-invalid');
          error?.classList.add('form-error');
          error.textContent = 'Este campo es obligatorio.';
          valid = false;
        } else {
          input.classList.remove('is-invalid');
          input.classList.add('is-valid');
          error?.classList.remove('form-error');
          error.textContent = '';
        }
      });

      if (!valid) {
        e.preventDefault();
        form.classList.add('audit-marker');
      }
    });
  });
}


/* === Part 3: Carousel, Performance, Debug, Accessibility, Export === */

/* === 9. CAROUSEL LOGIC === */
function initCarousel() {
  const container = $('.carousel-container');
  const track = $('.carousel-track', container);
  const slides = $$('.carousel-slide', track);
  const prevBtn = $('.carousel-button.prev', container);
  const nextBtn = $('.carousel-button.next', container);

  let currentIndex = 0;

  const updateCarousel = () => {
    const offset = -currentIndex * container.offsetWidth;
    track.style.transform = translateX(${offset}px);
  };

  const goToSlide = (index) => {
    currentIndex = (index + slides.length) % slides.length;
    updateCarousel();
  };

  nextBtn?.addEventListener('click', () => goToSlide(currentIndex + 1));
  prevBtn?.addEventListener('click', () => goToSlide(currentIndex - 1));

  window.addEventListener('resize', debounce(updateCarousel, 200));
  updateCarousel();
}

/* === 10. PERFORMANCE TRACING === */
function tracePerformance(label, color = 'green') {
  const marker = document.createElement('div');
  marker.className = 'trace-step';
  marker.style.borderLeftColor = color;
  marker.textContent = [TRACE] ${label};
  document.body.appendChild(marker);
  setTimeout(() => marker.remove(), 3000);
}

function traceStart(label) {
  const marker = document.createElement('div');
  marker.className = 'trace-start';
  marker.textContent = [START] ${label};
  document.body.appendChild(marker);
}

function traceEnd(label) {
  const marker = document.createElement('div');
  marker.className = 'trace-end';
  marker.textContent = [END] ${label};
  document.body.appendChild(marker);
}

/* === 11. DEBUG OVERLAYS === */
function initDebugOverlay() {
  const overlay = document.createElement('div');
  overlay.className = 'debug-overlay';
  document.body.appendChild(overlay);

  $$('.debug-box').forEach(box => {
    box.addEventListener('mouseenter', () => {
      box.style.backgroundColor = 'rgba(0,123,255,0.1)';
      box.style.borderColor = '#007bff';
    });
    box.addEventListener('mouseleave', () => {
      box.style.backgroundColor = 'rgba(0,123,255,0.05)';
      box.style.borderColor = 'rgba(0,123,255,0.5)';
    });
  });
}

/* === 12. ACCESSIBILITY ENHANCEMENTS === */
function initAccessibility() {
  $$('.skip-link').forEach(link => {
    link.addEventListener('focus', () => {
      link.style.top = '0';
    });
    link.addEventListener('blur', () => {
      link.style.top = '-40px';
    });
  });

  $$('.nav-link, .btn, .dropdown-toggle').forEach(el => {
    el.setAttribute('tabindex', '0');
    el.setAttribute('role', 'button');
    el.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        el.click();
      }
    });
  });
}

/* === 13. EXPORT HOOKS === */
function markModuleComplete(name) {
  const flag = document.createElement('div');
  flag.className = 'module-complete';
  flag.textContent = [MODULE COMPLETE] ${name};
  document.body.appendChild(flag);
}

function markModuleIncomplete(name) {
  const flag = document.createElement('div');
  flag.className = 'module-incomplete';
  flag.textContent = [MODULE INCOMPLETE] ${name};
  document.body.appendChild(flag);
}

function markModuleError(name, message) {
  const flag = document.createElement('div');
  flag.className = 'module-error';
  flag.textContent = [ERROR] ${name}: ${message};
  document.body.appendChild(flag);
}


/* === Part 4: Delegation, AJAX, Autosave, Plugins, Audit === */
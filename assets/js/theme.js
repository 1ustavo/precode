(() => {
  const STORAGE_KEY = "theme";
  const root = document.documentElement;

  const getStoredTheme = () => {
    try {
      return localStorage.getItem(STORAGE_KEY);
    } catch {
      return null;
    }
  };

  const setStoredTheme = (theme) => {
    try {
      localStorage.setItem(STORAGE_KEY, theme);
    } catch {
      // ignore (storage may be blocked)
    }
  };

  const applyTheme = (theme) => {
    if (theme === "dark") {
      root.setAttribute("data-theme", "dark");
    } else {
      root.setAttribute("data-theme", "light");
    }
  };

  const init = () => {
    const stored = getStoredTheme();
    const initial = stored === "dark" || stored === "light" ? stored : "light";
    applyTheme(initial);

    const btn = document.querySelector("[data-theme-toggle]");
    if (btn) {
      const syncLabel = () => {
        const current = root.getAttribute("data-theme") || "light";
        btn.setAttribute("aria-pressed", current === "dark" ? "true" : "false");
        btn.textContent = current === "dark" ? "Tema: escuro" : "Tema: claro";
      };

      syncLabel();
      btn.addEventListener("click", () => {
        const current = root.getAttribute("data-theme") || "light";
        const next = current === "dark" ? "light" : "dark";
        applyTheme(next);
        setStoredTheme(next);
        syncLabel();
      });
    }
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();


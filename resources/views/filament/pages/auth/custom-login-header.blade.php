<style>
    /* Background Override */
    body {
        background: #F3F4F6 !important;
    }
    body::before {
        content: '';
        position: fixed;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 50% 50%, rgba(79,70,229,0.08) 0%, transparent 60%),
                    radial-gradient(circle at 20% 80%, rgba(245,158,11,0.08) 0%, transparent 60%);
        pointer-events: none;
        z-index: -1;
    }

    /* Card Override */
    .fi-simple-main {
        max-width: 440px !important;
        margin: 0 auto;
    }
    .fi-simple-main > section {
        background: #FFFFFF !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1), 0 0 0 1px rgba(0,0,0,0.05) !important;
        border: none !important;
        padding: 16px !important;
    }

    /* Logo & Typography */
    .cl-logo-wrap {
        text-align: center;
        margin-bottom: 32px;
        margin-top: 16px;
    }
    .cl-logo-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: #FFFFFF;
        box-shadow: 0 8px 16px rgba(79,70,229,0.25);
    }
    .cl-logo-icon svg { width: 32px; height: 32px; }
    .cl-title {
        font-size: 24px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 8px;
    }
    .cl-subtitle {
        font-size: 15px;
        color: #6B7280;
    }

    /* Dark Mode */
    .dark body {
        background: #0F172A !important;
    }
    .dark body::before {
        background: radial-gradient(circle at 50% 50%, rgba(99,102,241,0.1) 0%, transparent 60%),
                    radial-gradient(circle at 20% 80%, rgba(245,158,11,0.05) 0%, transparent 60%);
    }
    .dark .fi-simple-main > section {
        background: #1E293B !important;
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.05) !important;
    }
    .dark .cl-title { color: #F8FAFC; }
    .dark .cl-subtitle { color: #94A3B8; }
</style>

<div class="cl-logo-wrap">
    <div class="cl-logo-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
        </svg>
    </div>
    <h1 class="cl-title">Selamat Datang</h1>
    <p class="cl-subtitle">Masuk untuk mengakses perpustakaan digital</p>
</div>

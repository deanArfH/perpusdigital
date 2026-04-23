<x-filament-panels::page.simple>
    <style>
        .cl-wrapper {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F3F4F6;
            z-index: -1;
            overflow: hidden;
        }
        .cl-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 50% 50%, rgba(79,70,229,0.08) 0%, transparent 60%),
                        radial-gradient(circle at 20% 80%, rgba(245,158,11,0.08) 0%, transparent 60%);
            pointer-events: none;
        }
        .cl-card {
            background: #FFFFFF;
            border-radius: 24px;
            padding: 48px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1), 0 0 0 1px rgba(0,0,0,0.05);
            position: relative;
            z-index: 10;
        }
        .cl-logo-wrap {
            text-align: center;
            margin-bottom: 32px;
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

        /* Override default Filament form styles for better look */
        .fi-simple-page { max-width: none !important; width: 100% !important; padding: 0 !important; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .fi-simple-main { width: 100%; max-width: 440px; }
        .fi-simple-layout { background: transparent !important; }
        .fi-logo { display: none !important; }
        .fi-simple-header { display: none !important; }

        /* Dark mode overrides */
        .dark .cl-wrapper { background: #0F172A; }
        .dark .cl-wrapper::before {
            background: radial-gradient(circle at 50% 50%, rgba(99,102,241,0.1) 0%, transparent 60%),
                        radial-gradient(circle at 20% 80%, rgba(245,158,11,0.05) 0%, transparent 60%);
        }
        .dark .cl-card {
            background: #1E293B;
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.05);
        }
        .dark .cl-title { color: #F8FAFC; }
        .dark .cl-subtitle { color: #94A3B8; }
    </style>

    <div class="cl-wrapper">
        <div class="cl-card">
            <div class="cl-logo-wrap">
                <div class="cl-logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h1 class="cl-title">Selamat Datang</h1>
                <p class="cl-subtitle">Masuk untuk mengakses perpustakaan digital</p>
            </div>

            {{-- The actual form from Filament --}}
            {{ $this->content }}
        </div>
    </div>
</x-filament-panels::page.simple>

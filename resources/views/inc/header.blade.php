<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;gap:20px;flex-wrap:wrap;">
    <div>
        <h1 style="font-size:26px;font-weight:800;letter-spacing:-0.8px;color:var(--text);">App / DipTek</h1>
        <div style="display:flex;align-items:center;gap:6px;margin-top:4px;">
            <span style="width:6px;height:6px;background:var(--success);border-radius:50%;"></span>
            <span style="font-size:12px;color:var(--secondary);">Live updates enabled</span>
        </div>
    </div>
    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
        <!-- Search Form -->
        <form action="/search" method="GET" style="display:flex;align-items:center;gap:0;background:white;border:1px solid var(--border);border-radius:10px;overflow:hidden;width:320px;transition:all 0.2s;box-shadow:0 1px 2px rgba(0,0,0,0.04);"
            onmouseover="this.style.borderColor='#c8c6c4';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)';"
            onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='0 1px 2px rgba(0,0,0,0.04)';">
            
            <!-- Search Icon -->
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--secondary)"
                stroke-width="2" stroke-linecap="round" style="margin-left:14px;flex-shrink:0;">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            
            <!-- Search Input -->
            <input type="text" name="q" placeholder="Search matches, players..."
                style="border:none;outline:none;font-size:13px;flex:1;background:transparent;color:var(--text);padding:8px 12px;min-width:0;cursor:pointer;"
                onclick="window.location.href='/joinmatch'" />
            
            <!-- Keyboard Shortcut -->
            <span
                style="font-size:10px;color:var(--secondary);background:var(--bg);padding:3px 7px;border-radius:5px;border:1px solid var(--border);font-weight:600;white-space:nowrap;margin-right:8px;">⌘
                K</span>
            
            <!-- Search Button -->
            <button type="submit" 
                style="
                    display:inline-flex;
                    align-items:center;
                    gap:6px;
                    padding:10px 16px;
                    border:none;
                    background:var(--blue);
                    font-size:12px;
                    font-weight:600;
                    color:white;
                    cursor:pointer;
                    transition:all 0.2s ease;
                    white-space:nowrap;
                    letter-spacing:0.3px;
                    box-shadow:none;
                "
                onmouseover="
                    this.style.background='var(--darkBlue)';
                    this.style.boxShadow='0 2px 8px rgba(0,120,212,0.3)';
                "
                onmouseout="
                    this.style.background='var(--blue)';
                    this.style.boxShadow='none';
                "
                onmousedown="
                    this.style.transform='scale(0.96)';
                "
                onmouseup="
                    this.style.transform='scale(1)';
                ">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                Search
            </button>
        </form>
        
        <div style="width:1px;height:28px;background:var(--border);"></div>

        <a href="/newmatch" style="text-decoration:none;">
            <button
                style="
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:11px 22px;
        border-radius:50px;
        border:none;
        background:#0d6efd;
        font-size:13px;
        font-weight:600;
        color:white;
        cursor:pointer;
        transition:all 0.25s ease;
        box-shadow:0 2px 10px rgba(13,110,253,0.3);
        font-family:'Inter', sans-serif;
        position:relative;
        overflow:hidden;
    "
                onmouseover="
        this.style.background='#0b5ed7';
        this.style.transform='translateY(-2px)';
        this.style.boxShadow='0 6px 20px rgba(13,110,253,0.4)';
    "
                onmouseout="
        this.style.background='#0d6efd';
        this.style.transform='translateY(0)';
        this.style.boxShadow='0 2px 10px rgba(13,110,253,0.3)';
    ">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                    style="transition:transform 0.25s ease;" onmouseover="this.style.transform='rotate(90deg)';"
                    onmouseout="this.style.transform='rotate(0deg)';">
                    <path d="M12 5v14M5 12h14" />
                </svg>
               Map Student
            </button>
        </a>
    </div>
</div>
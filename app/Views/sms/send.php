<div class="max-w-4xl mx-auto space-y-8">
    <!-- Form Card -->
    <div class="outline-card rounded-3xl p-8 backdrop-blur-md">
        <form id="sms-form" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div>
                    <label for="sender_name" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">Sender Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-rose-500/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="sender_name" id="sender_name" placeholder="Optional" 
                            class="outline-input block w-full pl-12 pr-4 py-4 rounded-xl text-gray-100 placeholder-gray-700 outline-none">
                    </div>
                </div>

                <div>
                    <label for="sim_slot" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">SIM Slot</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-rose-500/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                            </svg>
                        </div>
                        <select name="sim_slot" id="sim_slot" 
                            class="outline-input block w-full pl-12 pr-10 py-4 rounded-xl text-gray-100 appearance-none outline-none">
                            <option value="">OS Default</option>
                            <option value="1">SIM 1</option>
                            <option value="2">SIM 2</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 lg:col-span-1">
                    <label for="phone_number" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">Recipient Number</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-rose-500/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input type="text" name="phone_number" id="phone_number" placeholder="09xxxxxxxxx" required 
                            class="outline-input block w-full pl-12 pr-4 py-4 rounded-xl text-gray-100 placeholder-gray-700 outline-none">
                    </div>
                </div>
            </div>

            <div>
                <label for="message" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">Message Body</label>
                <textarea name="message" id="message" rows="5" required placeholder="Type your message here..."
                    class="outline-input block w-full px-5 py-5 rounded-2xl text-gray-100 placeholder-gray-700 outline-none resize-none"></textarea>
                <div class="flex justify-between mt-2 px-1">
                    <span id="char-count" class="text-[10px] text-gray-600 uppercase tracking-widest font-bold">0 / 160 characters</span>
                </div>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" id="send-btn" class="group relative overflow-hidden bg-rose-500 hover:bg-rose-600 text-white font-bold py-5 px-12 rounded-2xl shadow-xl shadow-rose-500/20 transition-all flex items-center space-x-3 active:scale-95">
                    <span class="relative z-10 flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span>Send Message</span>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 opacity-0 group-hover:animate-shimmer transition-opacity"></div>
                </button>
            </div>
        </form>
    </div>

    <!-- Stats Ticker -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="outline-card p-6 rounded-2xl flex items-center space-x-4 border-l-4 border-rose-500">
            <div class="p-3 bg-rose-500/5 rounded-lg text-rose-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold text-white"><?php echo count($logs ?? []); ?></span>
                <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Total Dispatched</p>
            </div>
        </div>
    </div>
</div>

<script>
const textArea = document.getElementById('message');
const charCount = document.getElementById('char-count');

textArea.addEventListener('input', (e) => {
    charCount.textContent = `${e.target.value.length} / 160 characters`;
});

document.getElementById('sms-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('send-btn');
    const originalContent = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = `
        <span class="flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Sending...</span>
        </span>
    `;

    try {
        const formData = new FormData(e.target);
        const response = await fetch('<?php echo $url("/send"); ?>', {
            method: 'POST',
            body: formData
        });
        
        let result;
        const text = await response.text();
        try {
            result = JSON.parse(text);
        } catch (e) {
            console.error('Server output:', text);
            alert('✕ Server Error: Received unexpected response. Check console for details.');
            return;
        }

        if (response.ok) {
            alert('✓ Message dispatched successfully!');
            e.target.reset();
            charCount.textContent = '0 / 160 characters';
        } else {
            alert('✕ Failed: ' + (result.error || result.warning || 'Unknown error'));
        }
    } catch (err) {
        console.error('Fetch error:', err);
        alert('✕ Network Error: Check your connection or server status');
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalContent;
    }
});
</script>

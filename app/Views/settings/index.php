<div class="max-w-4xl mx-auto space-y-12">
    <!-- Gateway Configuration -->
    <div class="outline-card rounded-3xl p-8 backdrop-blur-md">
        <h3 class="text-xl font-bold text-white mb-8 flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Gateway Credentials</span>
        </h3>

        <form action="<?php echo $url('/settings/update'); ?>" method="POST" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="api_username" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">API Username</label>
                    <input type="text" name="api_username" id="api_username" value="<?php echo htmlspecialchars($settings['api_username'] ?? ''); ?>" placeholder="Enter Username"
                        class="outline-input block w-full px-5 py-4 rounded-xl text-gray-100 placeholder-gray-700 outline-none">
                </div>
                <div>
                    <label for="api_password" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">API Password</label>
                    <input type="password" name="api_password" id="api_password" value="<?php echo htmlspecialchars($settings['api_password'] ?? ''); ?>" placeholder="Enter Password"
                        class="outline-input block w-full px-5 py-4 rounded-xl text-gray-100 placeholder-gray-700 outline-none">
                </div>
            </div>

            <div>
                <label for="device_id" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">Device ID</label>
                <input type="text" name="device_id" id="device_id" value="<?php echo htmlspecialchars($settings['device_id'] ?? ''); ?>" placeholder="e.g. cBlHGpBsjftWgi9..."
                    class="outline-input block w-full px-5 py-4 rounded-xl text-gray-100 placeholder-gray-700 outline-none">
                <p class="mt-2 text-[10px] text-gray-600 font-bold uppercase tracking-widest">Available in your Android SMS Gateway App settings</p>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-transparent border-2 border-rose-500 text-rose-500 hover:bg-rose-500 hover:text-white font-bold py-4 px-10 rounded-2xl transition-all active:scale-95 shadow-[0_0_15px_rgba(244,63,94,0.1)]">
                    Save Configuration
                </button>
            </div>
        </form>
    </div>

    <!-- API Key Integration -->
    <div class="outline-card rounded-3xl p-8 backdrop-blur-md">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-10 gap-4">
            <div>
                <h3 class="text-xl font-bold text-white flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    <span>API Integrations</span>
                </h3>
                <p class="text-xs text-gray-500 mt-1">Generate secret keys for external OTP systems</p>
            </div>
            <button onclick="document.getElementById('api-key-modal').classList.remove('hidden')" class="bg-rose-500/5 border border-rose-500/20 text-rose-500 hover:bg-rose-500 hover:text-white px-6 py-3 rounded-xl text-xs font-bold transition-all flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>New API Key</span>
            </button>
        </div>

        <div class="space-y-4">
            <?php if (empty($apiKeys)): ?>
                <div class="p-10 text-center border border-dashed border-gray-800 rounded-2xl">
                    <p class="text-gray-600 italic text-sm">No valid API keys found. Generate one to start integrating.</p>
                </div>
            <?php else: ?>
                <?php foreach ($apiKeys as $key): ?>
                    <div class="p-6 bg-gray-950/50 border border-gray-800 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-4 group hover:border-rose-500/20 transition-all">
                        <div class="space-y-2">
                            <div class="flex items-center space-x-3">
                                <span class="font-bold text-gray-200"><?php echo htmlspecialchars($key['name']); ?></span>
                                <span class="px-2 py-0.5 bg-gray-900 border border-gray-800 text-[9px] font-bold text-gray-500 rounded uppercase tracking-widest">Active</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <code class="text-rose-400 text-xs font-mono bg-rose-500/5 px-3 py-1.5 rounded-lg border border-rose-500/10 cursor-pointer" onclick="copyToClipboard('<?php echo $key['key_value']; ?>')" id="key-<?php echo $key['id']; ?>">••••••••••••••••••••••••••••••••</code>
                                <button onclick="toggleKeyVisibility(<?php echo $key['id']; ?>, '<?php echo $key['key_value']; ?>')" class="text-gray-600 hover:text-rose-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center space-x-6">
                            <div class="text-right hidden md:block">
                                <p class="text-[9px] font-bold text-gray-600 uppercase tracking-widest">Last Triggered</p>
                                <p class="text-[11px] text-gray-400"><?php echo $key['last_used_at'] ? date('M d, H:i', strtotime($key['last_used_at'])) : 'Never used'; ?></p>
                            </div>
                            <form action="<?php echo $url('/settings/api-keys/delete'); ?>" method="POST" onsubmit="return confirm('Revoke this key immediately?')">
                                <input type="hidden" name="id" value="<?php echo $key['id']; ?>">
                                <button type="submit" class="p-3 text-gray-700 hover:text-rose-500 hover:bg-rose-500/5 rounded-xl transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Comprehensive API Documentation -->
    <div class="outline-card rounded-3xl p-8 backdrop-blur-md">
        <div class="flex items-center justify-between mb-10">
            <h4 class="text-rose-500 font-bold flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Comprehensive Integration Guide</span>
            </h4>
            <div class="flex space-x-2">
                <span class="px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[9px] font-extrabold uppercase tracking-tighter rounded-full">v1.2 Stable</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left: Technical Specs -->
            <div class="space-y-10">
                <section>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-4">Authentication & Endpoint</p>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-4 bg-gray-950 rounded-xl border border-gray-800">
                            <span class="text-[10px] font-mono text-gray-500 uppercase">Method</span>
                            <span class="px-2 py-0.5 bg-rose-500/20 text-rose-500 text-[10px] font-bold rounded">POST</span>
                        </div>
                        <div class="flex flex-col p-4 bg-gray-950 rounded-xl border border-gray-800 space-y-2">
                            <span class="text-[10px] font-mono text-gray-500 uppercase">Gateway URL</span>
                            <code class="text-rose-400 text-xs break-all"><?php echo $url('/api/send'); ?></code>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-950 rounded-xl border border-gray-800">
                            <span class="text-[10px] font-mono text-gray-500 uppercase">Auth Header</span>
                            <code class="text-emerald-400 text-xs text-right">X-API-KEY</code>
                        </div>
                    </div>
                </section>

                <section>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-4">Data Normalization</p>
                    <div class="p-6 bg-blue-500/5 border border-blue-500/10 rounded-2xl">
                        <ul class="text-[11px] text-gray-400 space-y-3">
                            <li class="flex items-start space-x-2">
                                <span class="text-blue-500 mt-0.5">•</span>
                                <span>Phone numbers starting with <b class="text-gray-300">09...</b> are auto-converted to <b class="text-blue-400">+63...</b></span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-blue-500 mt-0.5">•</span>
                                <span>Supports both <b class="text-gray-300">JSON</b> and <b class="text-gray-300">Form-Data</b> payloads.</span>
                            </li>
                        </ul>
                    </div>
                </section>

                <section>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-4">Response Structure</p>
                    <div class="space-y-4">
                        <div class="rounded-xl overflow-hidden border border-gray-800">
                            <div class="bg-gray-900 px-4 py-2 text-[9px] font-bold text-gray-500 uppercase border-b border-gray-800 flex items-center justify-between">
                                <span>200 Success Response</span>
                                <span class="text-emerald-500">JSON</span>
                            </div>
                            <pre class="bg-gray-950 p-4 text-emerald-500/70 text-[10px] font-mono leading-relaxed">{
  "status": "Sent",
  "message_id": "85921-X",
  "api_response": { ... }
}</pre>
                        </div>
                        <div class="rounded-xl overflow-hidden border border-gray-800">
                            <div class="bg-gray-900 px-4 py-2 text-[9px] font-bold text-gray-500 uppercase border-b border-gray-800">400 / 401 Error Response</div>
                            <pre class="bg-gray-950 p-4 text-rose-500/70 text-[10px] font-mono leading-relaxed">{
  "error": "Invalid or missing API Key"
}</pre>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right: Code Snippets & Webhooks -->
            <div class="space-y-10">
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-3">PHP Integration</p>
                        <div class="relative group">
                            <pre class="bg-gray-950 p-5 rounded-2xl border border-gray-800 text-blue-400/80 text-[11px] font-mono overflow-x-auto leading-relaxed shadow-inner">
$ch = curl_init('<?php echo $url('/api/send'); ?>');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-API-KEY: YOUR_KEY_HERE',
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'phone_number' => '0929XXXXXXX',
    'message'      => 'Hello from the API!',
    'sender_name'  => 'MyApp',
    'sim_slot'     => 1
]));
$response = curl_exec($ch);
curl_close($ch);</pre>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-3">Python Integration</p>
                        <div class="relative group">
                            <pre class="bg-gray-950 p-5 rounded-2xl border border-gray-800 text-amber-500/80 text-[11px] font-mono overflow-x-auto leading-relaxed shadow-inner">
import requests

url = "<?php echo $url('/api/send'); ?>"
headers = { "X-API-KEY": "YOUR_KEY_HERE" }
data = {
    "phone_number": "0929XXXXXXX",
    "message": "Hello from Python!",
    "sender_name": "PythonScript"
}

response = requests.post(url, json=data, headers=headers)
print(response.json())</pre>
                        </div>
                    </div>
                </div>

                <section>
                    <div class="p-8 bg-rose-500/5 border border-rose-500/10 rounded-3xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h5 class="text-white font-bold text-sm mb-4">Android Gateway Webhook Setup</h5>
                        <p class="text-xs text-gray-500 leading-relaxed mb-6">
                            To receive real-time delivery status updates in this dashboard, set your Android SMS Gateway app's "Webhook URL" to:
                        </p>
                        <code class="block bg-gray-950 p-4 rounded-xl border border-gray-800 text-rose-400 text-[11px] mb-4 break-all">
                            <?php echo $url('/api/webhook'); ?>
                        </code>
                        <div class="flex items-center space-x-2 text-[10px] font-bold text-gray-600 uppercase tracking-widest">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Listens for "sms:sent", "sms:delivered", and "sms:failed"</span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="api-key-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-[100] flex items-center justify-center p-6">
    <div class="outline-card w-full max-w-md rounded-3xl p-10 shadow-2xl animate-slideUp">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-bold text-white">New API Key</h3>
            <button onclick="document.getElementById('api-key-modal').classList.add('hidden')" class="text-gray-500 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form action="<?php echo $url('/settings/api-keys/generate'); ?>" method="POST" class="space-y-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">Key Identifier</label>
                <input type="text" name="name" required placeholder="e.g. Mobile App OTP" 
                    class="outline-input block w-full px-5 py-4 rounded-xl text-gray-100 focus:outline-none">
            </div>
            <div class="flex pt-4">
                <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-5 rounded-2xl shadow-xl shadow-rose-500/20 transition-all active:scale-95">
                    Generate Key
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleKeyVisibility(id, value) {
    const el = document.getElementById('key-' + id);
    if (el.textContent.includes('•')) {
        el.textContent = value;
    } else {
        el.textContent = '••••••••••••••••••••••••••••••••';
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('✓ Key copied to clipboard');
    });
}
</script>

<style>
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-slideUp { animation: slideUp 0.3s ease-out forwards; }
</style>

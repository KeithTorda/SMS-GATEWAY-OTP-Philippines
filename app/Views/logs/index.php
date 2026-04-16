<div class="space-y-8">
    <div class="outline-card rounded-3xl overflow-hidden backdrop-blur-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-rose-500/10 bg-rose-500/[0.02]">
                        <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500">Sender</th>
                        <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500">SIM</th>
                        <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500">Recipient</th>
                        <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500">Message</th>
                        <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500">Status</th>
                        <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="6" class="px-8 py-16 text-center text-gray-600 italic font-medium">
                                No records found. Start sending to see logs here.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr class="hover:bg-rose-500/[0.01] transition-colors group">
                                <td class="px-8 py-6">
                                    <span class="text-rose-400 font-bold"><?php echo htmlspecialchars($log['sender_name'] ?? 'System'); ?></span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 rounded border border-gray-800 text-[10px] font-bold text-gray-400 group-hover:border-rose-500/20 transition-colors">
                                        <?php echo $log['sim_slot'] ? 'SLOT ' . htmlspecialchars($log['sim_slot']) : 'DEFAULT'; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-gray-300 font-medium"><?php echo htmlspecialchars($log['phone_number']); ?></span>
                                </td>
                                <td class="px-8 py-6 max-w-xs">
                                    <p class="text-gray-500 text-sm truncate" title="<?php echo htmlspecialchars($log['message']); ?>">
                                        <?php echo htmlspecialchars($log['message']); ?>
                                    </p>
                                </td>
                                <td class="px-8 py-6">
                                    <?php 
                                    $status = $log['status'];
                                    $statusClass = 'text-gray-500 bg-gray-500/5 border-gray-500/20';
                                    $dotClass = 'bg-gray-500';

                                    if ($status === 'Delivered') {
                                        $statusClass = 'text-emerald-500 bg-emerald-500/5 border-emerald-500/20';
                                        $dotClass = 'bg-emerald-500';
                                    } elseif (str_contains($status, 'Sent')) {
                                        $statusClass = 'text-blue-500 bg-blue-500/5 border-blue-500/20';
                                        $dotClass = 'bg-blue-500';
                                    } elseif (str_contains($status, 'Failed')) {
                                        $statusClass = 'text-rose-500 bg-rose-500/5 border-rose-500/20';
                                        $dotClass = 'bg-rose-500';
                                    }
                                    ?>
                                    <span class="inline-flex items-center space-x-2 <?php echo $statusClass; ?> text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded border">
                                        <span class="w-1.5 h-1.5 <?php echo $dotClass; ?> rounded-full"></span>
                                        <span><?php echo htmlspecialchars($status); ?></span>
                                    </span>
                                    <?php if (!empty($log['failed_reason'])): ?>
                                        <div class="mt-2 p-2 bg-rose-500/10 border border-rose-500/20 rounded-lg max-w-[200px]">
                                            <p class="text-[9px] text-rose-400 font-bold uppercase tracking-tighter mb-1">Failure Reason:</p>
                                            <p class="text-[10px] text-gray-300 leading-tight italic">
                                                "<?php echo htmlspecialchars($log['failed_reason']); ?>"
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-6 text-gray-600 text-xs font-medium">
                                    <div class="flex flex-col">
                                        <span><?php echo date('M d, H:i:s', strtotime($log['created_at'])); ?></span>
                                        <?php if (!empty($log['delivered_at'])): ?>
                                            <span class="text-[9px] text-emerald-500/50 mt-1">
                                                DELIVERED: <?php echo date('H:i:s', strtotime($log['delivered_at'])); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

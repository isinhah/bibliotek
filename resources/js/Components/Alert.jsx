import { usePage } from '@inertiajs/react';

export default function Alert() {
    const { flash } = usePage().props;

    if (!flash?.success && !flash?.error) return null;

    return (
        <div className="w-full max-w-xl mx-auto px-4 mt-6">
            {flash.success && (
                <div className="p-4 bg-slate-900 border border-slate-800 text-white rounded-2xl shadow-sm flex items-center gap-3 animate-fade-in">
                    <span className="w-2 h-2 rounded-full bg-[#b91c1c]"></span>
                    <span className="text-sm font-medium tracking-tight">{flash.success}</span>
                </div>
            )}

            {flash.error && (
                <div className="p-4 bg-rose-50 border border-rose-100 text-rose-900 rounded-2xl shadow-sm flex items-center gap-2.5">
                    <span className="text-rose-500 font-bold text-sm">✕</span>
                    <span className="text-sm font-medium tracking-tight">{flash.error}</span>
                </div>
            )}
        </div>
    );
}

import { usePage } from '@inertiajs/react';
import { useState, useEffect } from 'react';

export default function Alert() {
    const { props } = usePage();
    const flash = props?.flash;

    const [visible, setVisible] = useState(false);
    const [message, setMessage] = useState({ text: '', type: '' });

    useEffect(() => {
        if (flash?.success) {
            setMessage({ text: flash.success, type: 'success' });
            setVisible(true);
        } else if (flash?.error) {
            setMessage({ text: flash.error, type: 'error' });
            setVisible(true);
        }
    }, [flash, props]);

    useEffect(() => {
        if (visible) {
            const timer = setTimeout(() => {
                setVisible(false);
            }, 4000);
            return () => clearTimeout(timer);
        }
    }, [visible]);

    if (!visible || !message.text) return null;

    return (
        <div className="fixed bottom-5 right-5 z-50 max-w-md w-full px-4 sm:px-0 animate-slide-up">
            {message.type === 'success' ? (
                <div className="p-4 bg-slate-900 border border-slate-800 text-white rounded-2xl shadow-2xl flex items-center justify-between gap-3 backdrop-blur-md">
                    <div className="flex items-center gap-2.5">
                        <span className="w-2 h-2 rounded-full bg-[#b91c1c] animate-pulse"></span>
                        <span className="text-sm font-semibold tracking-tight text-white">
                            {message.text}
                        </span>
                    </div>
                    <button
                        onClick={() => setVisible(false)}
                        className="text-slate-400 hover:text-white text-xs pl-2 transition focus:outline-none"
                    >
                        ✕
                    </button>
                </div>
            ) : (
                <div className="p-4 bg-rose-50 border border-rose-100 text-rose-900 rounded-2xl shadow-2xl flex items-center justify-between gap-3">
                    <div className="flex items-center gap-2.5">
                        <span className="text-rose-500 font-bold text-sm">✕</span>
                        <span className="text-sm font-semibold tracking-tight text-rose-900">
                            {message.text}
                        </span>
                    </div>
                    <button
                        onClick={() => setVisible(false)}
                        className="text-rose-400 hover:text-rose-600 text-xs pl-2 transition focus:outline-none"
                    >
                        ✕
                    </button>
                </div>
            )}
        </div>
    );
}

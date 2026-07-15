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

    const isSuccess = message.type === 'success';

    return (
        <div className="fixed bottom-5 right-5 z-50 max-w-md w-full px-4 sm:px-0 animate-slide-up">
            <div
                className={`p-4 border-2 border-border-hard shadow-hard flex items-center justify-between gap-3 font-mono ${
                    isSuccess
                        ? 'bg-primary text-primary-foreground'
                        : 'bg-danger text-danger-foreground'
                }`}
            >
                <div className="flex items-center gap-2.5">
                    <span className="w-2 h-2 bg-current border border-border-hard flex-shrink-0"></span>
                    <span className="text-sm font-bold tracking-tight">
                        {message.text}
                    </span>
                </div>
                <button
                    onClick={() => setVisible(false)}
                    className="opacity-80 hover:opacity-100 text-xs pl-2 transition focus:outline-none font-bold"
                >
                    ✕
                </button>
            </div>
        </div>
    );
}

export default function Button({ type = 'submit', variant = 'primary', className = '', children, ...props }) {
    const baseClasses = "font-medium shadow-sm transition duration-200 focus:outline-none flex items-center justify-center";

    const variants = {
        primary: "bg-slate-950 hover:bg-[#b91c1c] text-white py-2.5 px-6 rounded-xl",
        danger: "bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded-lg text-sm focus:ring-2 focus:ring-red-500",
        secondary: "bg-slate-200 hover:bg-slate-300 text-slate-700 py-1 px-3 rounded-lg text-sm focus:ring-2 focus:ring-slate-400",
    };

    return (
        <button
            type={type}
            className={`${baseClasses} ${variants[variant]} ${className}`}
            {...props}
        >
            {children}
        </button>
    );
}

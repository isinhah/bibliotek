export default function SectionHeader({ title, subtitle, action, capitalize = false, highlightIcon = "bg-oak" }) {
    return (
        <div className="flex justify-between items-end mb-6 border-b-2 border-border pb-3">
            <div>
                <h2 className={`text-xs sm:text-sm font-minecraft text-text-primary uppercase tracking-wider flex items-center gap-2.5 [text-shadow:2px_2px_0_rgba(0,0,0,0.8)] ${capitalize ? 'capitalize' : ''}`}>
                    <span className={`w-2.5 h-2.5 border border-border-hard flex-shrink-0 ${highlightIcon}`}></span>
                    {title}
                </h2>
                {subtitle && (
                    <p className="text-xs text-text-secondary mt-1.5 font-mono font-bold">{subtitle}</p>
                )}
            </div>
            {action}
        </div>
    );
}

export default function EmptyState({ text }) {
    return (
        <div className="text-center py-16 bg-panel-alt border-2 border-border-hard shadow-hard max-w-xl mx-auto rounded-xl">
            <p className="text-text-secondary font-mono font-bold text-sm">{text}</p>
        </div>
    );
}

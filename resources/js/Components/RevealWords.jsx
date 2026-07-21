export default function RevealWords({ text, startDelay = 0, highlightLast = false }) {
    if (!text) return null;

    const words = text.split(' ');

    return (
        <span className="inline-block">
            {words.map((word, i) => {
                const isLast = highlightLast && i === words.length - 1;
                return (
                    <span key={i} className="inline-block overflow-hidden align-bottom mr-[0.28em] last:mr-0">
                        <span
                            className={`inline-block animate-word-reveal ${isLast ? 'text-primary' : ''}`}
                            style={{ animationDelay: `${startDelay + i * 0.09}s` }}
                        >
                            {word}
                        </span>
                    </span>
                );
            })}
        </span>
    );
}

import {Link, useForm} from '@inertiajs/react';
import Layout from '../Layouts/Layout';
import BookCard from '../Components/BookCard';

export default function Home({ categoriesWithBooks, searchTerm, searchResults, savedBookIds = [], loanedBookIds = [] }) {
    const { data, setData, get } = useForm({
        search: searchTerm || ''
    });

    const handleSearch = (e) => {
        e.preventDefault();
        get('/', { preserveState: true });
    };

    return (
        <>
            <div className="relative bg-page border-b-2 border-border-hard overflow-hidden pt-20 pb-24 bg-[radial-gradient(circle_at_center,rgba(225,29,72,0.04)_0%,transparent_70%)]">
                <div
                    className="absolute inset-0 opacity-[0.06] pointer-events-none"
                    style={{
                        backgroundImage:
                            'linear-gradient(#000 1px, transparent 1px), linear-gradient(90deg, #000 1px, transparent 1px)',
                        backgroundSize: '32px 32px',
                    }}
                />

                <header className="relative text-center px-4">
                    <div className="flex justify-center mb-6">
                        <div className="animate-float">
                            <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 bg-primary/30 rounded-full blur-3xl pointer-events-none animate-aurora-1"></div>
                            <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-40 h-40 bg-oak/20 rounded-full blur-3xl pointer-events-none animate-aurora-2"></div>

                            <img
                                src="/images/enchanted_book.gif"
                                alt="Livro Encantado"
                                className="relative z-10 w-32 h-32 md:w-36 md:h-36 object-contain drop-shadow-[0_10px_15px_rgba(225,29,72,0.6)]"
                            />
                        </div>
                    </div>

                    <h1 className="text-3xl sm:text-4xl md:text-5xl font-mono font-black text-text-primary tracking-tight uppercase max-w-2xl mx-auto leading-tight">
                        Encante a sua mente<br className="hidden sm:block" /> com uma nova leitura
                    </h1>
                    <p className="text-text-secondary mt-4 max-w-md mx-auto text-sm sm:text-base font-semibold">
                        Explore o acervo da Bibliotek e encontre sua próxima leitura.
                    </p>
                </header>

                <div className="relative mt-10 max-w-xl mx-auto px-4">
                    <form onSubmit={handleSearch} className="flex items-stretch gap-0 border-2 border-border-hard bg-panel-alt shadow-hard focus-within:shadow-none focus-within:translate-x-1 focus-within:translate-y-1 focus-within:border-primary transition-all duration-150 rounded-xl overflow-hidden">
                        <input
                            type="text"
                            value={data.search}
                            onChange={e => setData('search', e.target.value)}
                            placeholder="Pesquisar por título, autor..."
                            className="w-full px-4 py-3.5 bg-transparent text-sm font-mono text-text-primary placeholder-text-secondary/50 focus:outline-none"
                        />
                        <button
                            type="submit"
                            aria-label="Pesquisar"
                            className="shrink-0 px-5 bg-primary text-primary-foreground border-l-2 border-border-hard hover:bg-primary/90 active:translate-y-0.5 transition-colors flex items-center justify-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2.5} stroke="currentColor" className="w-5 h-5">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div className="container mx-auto px-4 py-12">
                {searchResults ? (
                    <section>
                        <SectionHeader title={`Resultados para: "${searchTerm}"`} />

                        {searchResults.data && searchResults.data.length === 0 ? (
                            <EmptyState text="Nenhum livro encontrado para a tua pesquisa." />
                        ) : (
                            <BookGrid
                                books={searchResults.data}
                                savedBookIds={savedBookIds}
                                loanedBookIds={loanedBookIds}
                            />
                        )}
                    </section>
                ) : (
                    <>
                        {Array.isArray(categoriesWithBooks) && categoriesWithBooks.map(category => (
                            <section key={category.id} className="mb-14">
                                <SectionHeader
                                    title={category.name}
                                    capitalize
                                    action={
                                        <Link
                                            href={`/categories/${category.id}/books`}
                                            className="text-xs font-bold uppercase tracking-wide text-oak hover:underline underline-offset-4 transition"
                                        >
                                            Ver tudo →
                                        </Link>
                                    }
                                />

                                <div className="flex gap-5 overflow-x-auto pb-4 px-1 snap-x snap-mandatory scroll-smooth custom-scrollbar">
                                    {category.books && category.books.map(book => (
                                        <div key={book.id} className="w-[260px] sm:w-[290px] md:w-[310px] flex-shrink-0 snap-start">
                                            <BookCard
                                                book={book}
                                                isSaved={savedBookIds.includes(book.id)}
                                                hasActiveLoan={loanedBookIds.includes(book.id)}
                                            />
                                        </div>
                                    ))}
                                </div>
                            </section>
                        ))}
                    </>
                )}
            </div>

            <style>{`
                @keyframes pulseGlow {
                    0%, 100% { opacity: 0.4; transform: scale(1); }
                    50% { opacity: 0.7; transform: scale(1.15); }
                }
                .animate-glow-pulse {
                    animation: pulseGlow 3s ease-in-out infinite;
                }
            `}</style>
        </>
    );
}

function SectionHeader({ title, subtitle, action, capitalize = false }) {
    return (
        <div className="flex justify-between items-end mb-6 border-b-2 border-border pb-3">
            <div>
                <h2 className={`text-lg sm:text-xl font-mono font-black text-text-primary uppercase tracking-tight flex items-center gap-2.5 ${capitalize ? 'capitalize' : ''}`}>
                    <span className="w-2.5 h-2.5 bg-oak border border-border-hard flex-shrink-0"></span>
                    {title}
                </h2>
                {subtitle && (
                    <p className="text-xs text-text-secondary mt-1 font-mono font-bold">{subtitle}</p>
                )}
            </div>
            {action}
        </div>
    );
}

function EmptyState({ text }) {
    return (
        <div className="text-center py-16 bg-panel-alt border-2 border-border-hard shadow-hard max-w-xl mx-auto rounded-xl">
            <p className="text-text-secondary font-mono font-bold text-sm">{text}</p>
        </div>
    );
}

function BookGrid({ books, savedBookIds, loanedBookIds }) {
    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            {books && books.map(book => (
                <BookCard
                    key={book.id}
                    book={book}
                    isSaved={savedBookIds.includes(book.id)}
                    hasActiveLoan={loanedBookIds.includes(book.id)}
                />
            ))}
        </div>
    );
}

Home.layout = page => <Layout children={page} title="Bibliotek" isHome={true} />

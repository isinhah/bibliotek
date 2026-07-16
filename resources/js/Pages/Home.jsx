import { Link, useForm } from '@inertiajs/react';
import Layout from '../Layouts/Layout';
import BookCard from '../Components/BookCard';
import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselPrevious,
    CarouselNext,
} from '@/Components/ui/carousel.jsx';

const MAX_HOME_CATEGORIES = 6;

export default function Home({ categoriesWithBooks, searchTerm, searchResults, savedBookIds = [], loanedBookIds = [] }) {
    const { data, setData, get } = useForm({
        search: searchTerm || ''
    });

    const handleSearch = (e) => {
        e.preventDefault();
        get('/', { preserveState: true });
    };

    const categories = Array.isArray(categoriesWithBooks)
        ? categoriesWithBooks.slice(0, MAX_HOME_CATEGORIES)
        : [];
    const hasMoreCategories = Array.isArray(categoriesWithBooks) && categoriesWithBooks.length > MAX_HOME_CATEGORIES;

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
                        <div className="relative w-40 h-40 flex items-center justify-center">
                            <div className="absolute inset-0 m-auto w-52 h-52 bg-oak/25 rounded-full blur-3xl pointer-events-none animate-glow-1"></div>
                            <div className="absolute inset-0 m-auto w-44 h-44 bg-primary/20 rounded-full blur-3xl pointer-events-none animate-glow-2"></div>
                            <div className="absolute inset-0 m-auto w-28 h-28 bg-oak-light/25 rounded-full blur-2xl pointer-events-none animate-glow-3"></div>

                            <span className="animate-summon-ring absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 rounded-full border-2 border-oak-light pointer-events-none"></span>

                            <span className="animate-spark absolute top-1/2 left-1/2 w-1.5 h-1.5 rounded-full bg-oak-light shadow-[0_0_6px_2px_rgba(245,158,11,0.6)]" style={{ '--spark-angle': '0deg' }}></span>
                            <span className="animate-spark absolute top-1/2 left-1/2 w-1.5 h-1.5 rounded-full bg-oak-light shadow-[0_0_6px_2px_rgba(245,158,11,0.6)]" style={{ '--spark-angle': '60deg', animationDelay: '0.1s' }}></span>
                            <span className="animate-spark absolute top-1/2 left-1/2 w-1.5 h-1.5 rounded-full bg-oak-light shadow-[0_0_6px_2px_rgba(245,158,11,0.6)]" style={{ '--spark-angle': '120deg', animationDelay: '0.2s' }}></span>
                            <span className="animate-spark absolute top-1/2 left-1/2 w-1.5 h-1.5 rounded-full bg-primary shadow-[0_0_6px_2px_rgba(225,29,72,0.6)]" style={{ '--spark-angle': '180deg', animationDelay: '0.05s' }}></span>
                            <span className="animate-spark absolute top-1/2 left-1/2 w-1.5 h-1.5 rounded-full bg-oak-light shadow-[0_0_6px_2px_rgba(245,158,11,0.6)]" style={{ '--spark-angle': '240deg', animationDelay: '0.15s' }}></span>
                            <span className="animate-spark absolute top-1/2 left-1/2 w-1.5 h-1.5 rounded-full bg-oak-light shadow-[0_0_6px_2px_rgba(245,158,11,0.6)]" style={{ '--spark-angle': '300deg', animationDelay: '0.25s' }}></span>

                            <div className="animate-summon">
                                <div className="animate-float-loop">
                                    <img
                                        src="/images/enchanted_book.gif"
                                        alt="Livro Encantado"
                                        className="relative z-10 w-32 h-32 md:w-36 md:h-36 object-contain drop-shadow-[0_10px_18px_rgba(217,119,6,0.45)]"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <h1 className="font-minecraft text-2xl sm:text-3xl md:text-4xl text-text-primary uppercase max-w-2xl mx-auto leading-relaxed [text-shadow:3px_3px_0_rgba(0,0,0,0.7)]">
                        <RevealWords text="Encante a sua mente" startDelay={0.35} />
                        <br className="hidden sm:block" />
                        <RevealWords text="com uma nova leitura" startDelay={0.35 + 0.35} highlightLast />
                    </h1>
                    <p className="text-text-secondary mt-5 max-w-md mx-auto text-sm sm:text-base font-semibold animate-fade-in-up" style={{ animationDelay: '1.3s' }}>
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
                        {categories.map(category => (
                            <section key={category.id} className="mb-16">
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

                                <CategoryCarousel
                                    books={category.books}
                                    savedBookIds={savedBookIds}
                                    loanedBookIds={loanedBookIds}
                                />
                            </section>
                        ))}

                        {hasMoreCategories && (
                            <div className="text-center mt-4 mb-8">
                                <Link
                                    href="/categories"
                                    className="inline-flex items-center gap-2 border-2 border-border-hard bg-panel px-6 py-3 text-xs font-bold uppercase tracking-wide text-text-primary shadow-hard hover:bg-primary hover:text-primary-foreground active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all duration-150"
                                >
                                    Ver todas as categorias →
                                </Link>
                            </div>
                        )}
                    </>
                )}
            </div>
        </>
    );
}

function CategoryCarousel({ books, savedBookIds, loanedBookIds }) {
    if (!books || books.length === 0) return null;

    return (
        <Carousel
            opts={{ align: 'start', loop: false }}
            className="px-1 sm:px-2"
        >
            <CarouselContent>
                {books.map(book => (
                    <CarouselItem
                        key={book.id}
                        className="basis-full sm:basis-1/2 lg:basis-1/4"
                    >
                        <BookCard
                            book={book}
                            isSaved={savedBookIds.includes(book.id)}
                            hasActiveLoan={loanedBookIds.includes(book.id)}
                        />
                    </CarouselItem>
                ))}
            </CarouselContent>

            <CarouselPrevious className="hidden sm:flex" />
            <CarouselNext className="hidden sm:flex" />
        </Carousel>
    );
}

function RevealWords({ text, startDelay = 0, highlightLast = false }) {
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

function SectionHeader({ title, subtitle, action, capitalize = false }) {
    return (
        <div className="flex justify-between items-end mb-6 border-b-2 border-border pb-3">
            <div>
                <h2 className={`text-xs sm:text-sm font-minecraft text-text-primary uppercase tracking-wider flex items-center gap-2.5 [text-shadow:2px_2px_0_rgba(0,0,0,0.8)] ${capitalize ? 'capitalize' : ''}`}>
                    <span className="w-2.5 h-2.5 bg-oak border border-border-hard flex-shrink-0 animate-pulse"></span>
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

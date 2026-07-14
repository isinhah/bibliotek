import { Link, useForm, usePage } from '@inertiajs/react';
import Layout from '../Layouts/Layout';
import BookCard from '../Components/BookCard';
import { Button } from "@/Components/ui/button";

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
            <div className="bg-slate-950 text-slate-100 shadow-lg pb-16 pt-16">
                <header className="text-center px-4">
                    <h1 className="text-4xl md:text-5xl font-black text-white tracking-tighter">
                        Bem vindo ao acervo.
                    </h1>
                    <p className="text-slate-400 mt-4 max-w-lg mx-auto text-lg">
                        Explore a bibliotek e encontre sua próxima leitura.
                    </p>
                </header>

                <Button>CLIQUE AQUI</Button>

                <div className="mt-10 max-w-xl mx-auto px-4">
                    <form onSubmit={handleSearch} className="relative group">
                        <input
                            type="text"
                            value={data.search}
                            onChange={e => setData('search', e.target.value)}
                            placeholder="Pesquisar pelo título do livro..."
                            className="w-full pl-6 pr-12 py-4 bg-slate-900 border border-slate-800 rounded-2xl shadow-inner text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-[#b91c1c] focus:border-transparent transition-all"
                        />
                        <button type="submit" className="absolute right-4 top-4 text-slate-500 hover:text-[#b91c1c] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div className="container mx-auto px-4 py-12">
                {searchResults ? (
                    <div>
                        <div className="flex justify-between items-baseline mb-6 border-b border-slate-100 pb-3">
                            <h2 className="text-xl font-extrabold text-slate-950 tracking-tight flex items-center gap-2">
                                <span className="w-1.5 h-4 rounded-full bg-[#b91c1c]"></span>
                                Resultados para: "{searchTerm}"
                            </h2>
                        </div>

                        {searchResults.data && searchResults.data.length === 0 ? (
                            <div className="text-center py-16 bg-white border border-slate-100 rounded-2xl max-w-xl mx-auto shadow-sm">
                                <p className="text-slate-500 font-medium">Nenhum livro encontrado para a tua pesquisa.</p>
                            </div>
                        ) : (
                            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                {searchResults.data && searchResults.data.map(book => (
                                    <div key={book.id} className="relative group">
                                        <BookCard
                                            book={book}
                                            isSaved={savedBookIds.includes(book.id)}
                                            hasActiveLoan={loanedBookIds.includes(book.id)}
                                        />
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                ) : (
                    Array.isArray(categoriesWithBooks) && categoriesWithBooks.map(category => (
                        <section key={category.id} className="mb-14">
                            <div className="flex justify-between items-baseline mb-6 border-b border-slate-100 pb-3">
                                <h2 className="text-xl font-extrabold text-slate-950 tracking-tight flex items-center gap-2">
                                    <span className="w-1.5 h-4 rounded-full bg-[#b91c1c]"></span>
                                    <span className="capitalize">{category.name}</span>
                                </h2>
                                <Link
                                    href={`/categories/${category.id}/books`}
                                    className="text-sm font-semibold text-[#b91c1c] hover:underline underline-offset-4 transition"
                                >
                                    Ver tudo →
                                </Link>
                            </div>

                            <div className="flex gap-6 overflow-x-auto pb-4 px-2 snap-x snap-mandatory scroll-smooth custom-scrollbar">
                                {category.books && category.books.map(book => (
                                    <div key={book.id} className="w-[280px] sm:w-[320px] md:w-[350px] flex-shrink-0 snap-start relative group">
                                        <BookCard
                                            book={book}
                                            isSaved={savedBookIds.includes(book.id)}
                                            hasActiveLoan={loanedBookIds.includes(book.id)}
                                        />
                                    </div>
                                ))}
                            </div>
                        </section>
                    ))
                )}
            </div>

            <style>{`
                .custom-scrollbar::-webkit-scrollbar {
                    height: 10px;
                }
                .custom-scrollbar::-webkit-scrollbar-track {
                    background: transparent;
                }
                .custom-scrollbar::-webkit-scrollbar-thumb {
                    background: #cbd5e1;
                    border-radius: 10px;
                    transition: background 0.2s ease;
                }
                .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                    background: #b91c1c;
                    cursor: grabbing;
                }
            `}</style>
        </>
    );
}

Home.layout = page => <Layout children={page} title="Bibliotek" isHome={true} />

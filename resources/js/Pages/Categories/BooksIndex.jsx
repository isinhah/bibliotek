import { useForm, Link } from '@inertiajs/react';
import Layout from '../../Layouts/Layout';
import BookCard from '../../Components/BookCard';
import { Button } from "@/Components/ui/Button.jsx";

export default function BooksIndex({ category, books, searchTerm, savedBookIds = [] , loanedBookIds = [] }) {
    const { data, setData, get } = useForm({
        search: searchTerm || ''
    });

    const handleSearch = (e) => {
        e.preventDefault();
        get(`/categories/${category.id}/books`, { preserveState: true });
    };

    const handleClearSearch = () => {
        setData('search', '');
        get(`/categories/${category.id}/books?search=`, { preserveState: true });
    };

    return (
        <>
            <header className="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6 pb-6 border-b-2 border-border-hard">
                <div>
                    <Link
                        href="/categories"
                        className="text-sm font-mono font-bold text-text-secondary hover:text-primary transition-colors duration-150 flex items-center gap-1"
                    >
                        ← Voltar para Categorias
                    </Link>
                    <h1 className="text-3xl sm:text-4xl font-mono font-black text-text-primary tracking-tight mt-2 flex items-center gap-3">
                        <span className="w-2.5 h-8 bg-oak border-2 border-border-hard rounded-none"></span>
                        <span className="capitalize">{category.name}</span>
                    </h1>
                </div>

                <span className="text-xs font-mono font-bold uppercase tracking-wider text-text-primary bg-panel-alt border-2 border-border-hard px-3 py-1.5 rounded-none shadow-hard">
                    {books.total || books.data?.length || 0} {books.total === 1 ? 'livro disponível' : 'livros disponíveis'}
                </span>
            </header>

            <div className="mb-14">
                <form onSubmit={handleSearch} className="flex flex-col sm:flex-row gap-3 w-full max-w-xl">
                    <div className="relative flex-1">
                        <input
                            type="text"
                            value={data.search}
                            onChange={e => setData('search', e.target.value)}
                            placeholder="Pesquisar livros nesta categoria..."
                            className="w-full font-mono text-xs font-semibold bg-panel-alt text-text-primary border-2 border-border-hard rounded-none h-10 pl-4 pr-10 outline-none focus:ring-2 focus:ring-primary focus:border-border-hard shadow-hard placeholder:text-text-secondary/50"
                        />
                        {data.search && (
                            <button
                                type="button"
                                onClick={handleClearSearch}
                                className="absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary hover:text-danger font-mono font-bold text-xs"
                            >
                                ✕
                            </button>
                        )}
                    </div>
                    <Button type="submit" variant="primary" className="h-10">
                        Buscar
                    </Button>
                </form>
            </div>

            {books.data && books.data.length === 0 ? (
                <div className="text-center py-24 bg-panel-alt border-2 border-border-hard rounded-none shadow-hard max-w-lg mx-auto">
                    <span className="text-4xl block mb-4">📖</span>
                    <p className="text-text-primary font-mono font-bold text-sm">
                        Nenhum livro encontrado nesta categoria.
                    </p>
                </div>
            ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    {books.data && books.data.map(book => (
                        <div key={book.id} className="h-full">
                            <BookCard
                                book={book}
                                isSaved={savedBookIds.includes(book.id)}
                                hasActiveLoan={loanedBookIds.includes(book.id)}
                            />
                        </div>
                    ))}
                </div>
            )}

            {books.links && books.data && books.data.length > 0 && (
                <div className="mt-12 flex justify-between items-center bg-panel px-6 py-4 rounded-none border-2 border-border-hard shadow-hard">
                    {books.prev_page_url ? (
                        <Link
                            href={books.prev_page_url}
                            className="group/button inline-flex h-10 px-5 gap-2 shrink-0 items-center justify-center rounded-none border-2 border-border-hard font-mono text-xs font-bold uppercase select-none outline-none active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all bg-secondary text-secondary-foreground hover:bg-secondary/80 shadow-hard"
                        >
                            ◀ Anterior
                        </Link>
                    ) : (
                        <span className="group/button inline-flex h-10 px-5 gap-2 shrink-0 items-center justify-center rounded-none border-transparent bg-transparent text-text-primary font-mono text-xs font-bold uppercase select-none opacity-50 cursor-not-allowed">
                            ◀ Anterior
                        </span>
                    )}

                    <span className="font-mono text-xs font-bold text-text-secondary">
                        Pág. {books.current_page} de {books.last_page}
                    </span>

                    {books.next_page_url ? (
                        <Link
                            href={books.next_page_url}
                            className="group/button inline-flex h-10 px-5 gap-2 shrink-0 items-center justify-center rounded-none border-2 border-border-hard font-mono text-xs font-bold uppercase select-none outline-none active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all bg-secondary text-secondary-foreground hover:bg-secondary/80 shadow-hard"
                        >
                            Próximo ▶
                        </Link>
                    ) : (
                        <span className="group/button inline-flex h-10 px-5 gap-2 shrink-0 items-center justify-center rounded-none border-transparent bg-transparent text-text-primary font-mono text-xs font-bold uppercase select-none opacity-50 cursor-not-allowed">
                            Próximo ▶
                        </span>
                    )}
                </div>
            )}
        </>
    );
}

BooksIndex.layout = page => <Layout children={page} title={`Livros em ${page?.props?.category?.name || 'Categoria'}`} />

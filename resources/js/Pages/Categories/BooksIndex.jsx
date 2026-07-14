import { useForm, Link } from '@inertiajs/react';
import Layout from '../../Layouts/Layout';
import BookCard from '../../Components/BookCard';
import { Button } from "@/Components/ui/Button.jsx"; // 🚀 Importado corretamente

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
                        <span className="w-2.5 h-8 bg-oak border-2 border-border-hard rounded-xs"></span>
                        <span className="capitalize">{category.name}</span>
                    </h1>
                </div>

                <div className="w-full md:w-auto">
                    <form onSubmit={handleSearch} className="flex flex-col sm:flex-row gap-3 w-full">
                        <div className="relative flex-1 sm:w-80">
                            <input
                                type="text"
                                value={data.search}
                                onChange={e => setData('search', e.target.value)}
                                placeholder="Pesquisar neste acervo..."
                                className="w-full font-mono text-xs font-semibold bg-panel-alt text-text-primary border-2 border-border-hard rounded-xl h-10 pl-4 pr-10 outline-none  shadow-hard placeholder:text-text-secondary/50"
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
            </header>

            {books.data.length === 0 ? (
                <div className="text-center py-24 bg-panel border-2 border-border-hard rounded-xl shadow-hard max-w-lg mx-auto">
                    <p className="text-text-primary font-mono font-bold text-sm">
                        Nenhum livro disponível nesta categoria no momento.
                    </p>
                </div>
            ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    {books.data.map(book => (
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

            {/* Paginação Neo-Brutalista Arredondada */}
            {books.links && books.links.length > 3 && (
                <div className="mt-12 flex justify-between items-center bg-panel px-6 py-4 rounded-xl border-2 border-border-hard shadow-hard">
                    <Button
                        asChild={!!books.prev_page_url}
                        variant={books.prev_page_url ? "secondary" : "ghost"}
                        className={!books.prev_page_url ? "opacity-50 cursor-not-allowed pointer-events-none" : ""}
                    >
                        {books.prev_page_url ? (
                            <Link href={books.prev_page_url}>
                                ◀ Anterior
                            </Link>
                        ) : (
                            <span>◀ Anterior</span>
                        )}
                    </Button>

                    <span className="font-mono text-xs font-bold text-text-secondary">
                        Pág. {books.current_page} de {books.last_page}
                    </span>

                    <Button
                        asChild={!!books.next_page_url}
                        variant={books.next_page_url ? "secondary" : "ghost"}
                        className={!books.next_page_url ? "opacity-50 cursor-not-allowed pointer-events-none" : ""}
                    >
                        {books.next_page_url ? (
                            <Link href={books.next_page_url}>
                                Próximo ▶
                            </Link>
                        ) : (
                            <span>Próximo ▶</span>
                        )}
                    </Button>
                </div>
            )}
        </>
    );
}

BooksIndex.layout = page => <Layout children={page} title={`Livros em ${page?.props?.category?.name || 'Categoria'}`} />

import { useForm, usePage, Link } from '@inertiajs/react';
import Layout from '../../Layouts/Layout';
import Alert from '../../Components/Alert';
import BookCard from '../../Components/BookCard';

export default function BooksIndex({ category, books, searchTerm, savedBookIds = [] }) {
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
            <div className="mb-6">
                <Alert />
            </div>

            <header className="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-6 border-b border-slate-100">
                <div>
                    <Link
                        href="/categories"
                        className="text-sm font-semibold text-slate-500 hover:text-[#b91c1c] transition-colors duration-150 flex items-center gap-1"
                    >
                        ← Voltar para Categorias
                    </Link>
                    <h1 className="text-3xl sm:text-4xl font-black text-slate-950 tracking-tighter mt-2 flex items-center gap-3">
                        <span className="w-1.5 h-8 bg-[#b91c1c] rounded-full"></span>
                        <span className="capitalize">{category.name}</span>
                    </h1>
                </div>

                <span className="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200/40">
                    Total: {books.total} {books.total === 1 ? 'livro' : 'livros'}
                </span>
            </header>

            <div className="mb-14 max-w-xl">
                <form onSubmit={handleSearch} className="relative group">
                    <input
                        type="text"
                        value={data.search}
                        onChange={e => setData('search', e.target.value)}
                        placeholder={`Pesquisar livro em ${category.name}...`}
                        className="w-full pl-6 pr-12 py-3.5 bg-white border border-slate-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#b91c1c] focus:border-transparent transition-all placeholder-slate-400 text-sm font-medium"
                    />

                    {searchTerm && (
                        <button
                            type="button"
                            onClick={handleClearSearch}
                            className="absolute right-12 top-3.5 text-slate-400 hover:text-slate-600 text-sm transition"
                        >
                            ✕
                        </button>
                    )}

                    <button type="submit" className="absolute right-4 top-3.5 text-slate-400 hover:text-[#b91c1c] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-5 h-5">
                            <path strokeLinecap="round" strokeLinejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </form>

                {searchTerm && (
                    <div className="text-xs text-slate-400 font-medium mt-2 pl-2">
                        Encontrado(s) {books.total} livro(s) para "{searchTerm}"
                    </div>
                )}
            </div>

            {books.data.length === 0 ? (
                <div className="bg-white p-16 rounded-2xl shadow-sm text-center border border-slate-100 text-slate-500 text-sm font-medium">
                    Nenhum livro encontrado nesta categoria.
                </div>
            ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    {books.data.map(book => (
                        <div key={book.id} className="relative group">
                            <BookCard
                                book={book}
                                isSaved={savedBookIds.includes(book.id)}
                            />
                        </div>
                    ))}
                </div>
            )}

            {books.links && books.data.length > 0 && (
                <div className="mt-12 flex justify-between items-center bg-white px-4 py-3 rounded-xl border border-slate-100 shadow-xs">
                    <Link
                        href={books.prev_page_url || '#'}
                        disabled={!books.prev_page_url}
                        className={`px-4 py-2 text-xs font-semibold rounded-lg border transition ${
                            books.prev_page_url
                                ? 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50'
                                : 'bg-slate-50 border-slate-100 text-slate-300 cursor-not-allowed'
                        }`}
                    >
                        Anterior
                    </Link>
                    <Link
                        href={books.next_page_url || '#'}
                        disabled={!books.next_page_url}
                        className={`px-4 py-2 text-xs font-semibold rounded-lg border transition ${
                            books.next_page_url
                                ? 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50'
                                : 'bg-slate-50 border-slate-100 text-slate-300 cursor-not-allowed'
                        }`}
                    >
                        Próximo
                    </Link>
                </div>
            )}
        </>
    );
}

BooksIndex.layout = page => <Layout children={page} title={`Livros em ${page?.props?.category?.name || 'Categoria'}`} />

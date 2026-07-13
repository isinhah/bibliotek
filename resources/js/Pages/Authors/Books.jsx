import { Link } from '@inertiajs/react';
import Layout from '../../Layouts/Layout';
import Alert from '../../Components/Alert';
import BookCard from '../../Components/BookCard';

export default function Books({ author, books, savedBookIds = [] }) {
    return (
        <>
            <div className="mb-6">
                <Alert />
            </div>

            <header className="mb-12 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 pb-6 border-b border-slate-100">
                <div>
                    <Link
                        href="/authors"
                        className="text-sm font-semibold text-slate-500 hover:text-[#b91c1c] transition-colors duration-150 flex items-center gap-1"
                    >
                        ← Voltar para Autores
                    </Link>
                    <h1 className="text-3xl sm:text-4xl font-black text-slate-950 tracking-tighter mt-2 flex items-center gap-3">
                        <span className="w-1.5 h-8 bg-[#b91c1c] rounded-full"></span>
                        <span className="capitalize">{author.name}</span>
                    </h1>
                </div>

                <span className="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200/40">
                    {books.length} {books.length === 1 ? 'obra disponível' : 'obras disponíveis'}
                </span>
            </header>

            {books.length === 0 ? (
                <div className="bg-white p-16 rounded-2xl shadow-sm text-center border border-slate-100 text-slate-500 text-sm font-medium">
                    Este autor não possui livros cadastrados no momento.
                </div>
            ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    {books.map(book => (
                        <BookCard
                            key={book.id}
                            book={book}
                            isSaved={savedBookIds.includes(book.id)}
                        />
                    ))}
                </div>
            )}
        </>
    );
}

Books.layout = page => <Layout children={page} title={`Livros de ${page?.props?.author?.name || 'Autor'}`} />

import { Link } from '@inertiajs/react';
import Layout from '../../Layouts/Layout';
import BookCard from '../../Components/BookCard';

export default function Books({ author, books, savedBookIds = [], loanedBookIds = [] }) {
    return (
        <>
            <header className="mb-12 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 pb-6 border-b-2 border-border-hard">
                <div>
                    <Link
                        href="/authors"
                        className="text-sm font-mono font-bold text-text-secondary hover:text-primary transition-colors duration-150 flex items-center gap-1"
                    >
                        ← Voltar para Autores
                    </Link>
                    <h1 className="text-3xl sm:text-4xl font-mono font-black text-text-primary tracking-tight mt-2 flex items-center gap-3">
                        <span className="w-2.5 h-8 bg-oak border-2 border-border-hard rounded-none"></span>
                        <span className="capitalize">{author.name}</span>
                    </h1>
                </div>

                <span className="text-xs font-mono font-bold uppercase tracking-wider text-text-primary bg-panel-alt border-2 border-border-hard px-3 py-1.5 rounded-none shadow-hard">
                    {books.length} {books.length === 1 ? 'obra disponível' : 'obras disponíveis'}
                </span>
            </header>

            {books.length === 0 ? (
                <div className="text-center py-24 bg-panel-alt border-2 border-border-hard rounded-none shadow-hard max-w-lg mx-auto">
                    <p className="text-text-primary font-mono font-bold text-sm">
                        Este autor não possui livros cadastrados no momento.
                    </p>
                </div>
            ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    {books.map(book => (
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
        </>
    );
}

Books.layout = page => <Layout children={page} title={`Livros de ${page?.props?.author?.name || 'Autor'}`} />

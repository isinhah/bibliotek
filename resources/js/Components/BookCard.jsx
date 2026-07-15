import { useForm, usePage, Link } from '@inertiajs/react';
import { Button } from "@/Components/ui/Button";

export default function BookCard({ book, isSaved, hasActiveLoan = false }) {
    const { auth } = usePage().props || {};
    const isAuthenticated = !!auth?.user;
    const isAdmin = auth?.user?.role === 'admin';

    const readingListForm = useForm();
    const loanForm = useForm();

    const handleToggleReadingList = (e) => {
        e.preventDefault();
        readingListForm.post(`/reading-list/toggle/${book.id}`, { preserveScroll: true });
    };

    const handleLoan = (e) => {
        e.preventDefault();
        if (book.stock > 0 && !hasActiveLoan) {
            loanForm.post(`/books/${book.id}/loan`, { preserveScroll: true });
        }
    };

    const coverUrl = book.cover_id
        ? (Number.isInteger(Number(book.cover_id))
            ? `https://covers.openlibrary.org/b/id/${book.cover_id}-M.jpg`
            : `/storage/${book.cover_id}`)
        : null;

    const isLoanButtonDisabled = loanForm.processing || hasActiveLoan || book.stock <= 0;

    return (
        <div className="group bg-panel-alt border-2 border-border-hard rounded-none p-4 sm:p-5 flex flex-col justify-between hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[6px_6px_0px_0px_#000000] shadow-hard transition-all duration-200 h-full relative">

            {isAdmin && (
                <div className="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                    <a
                        href={`/admin/books/${book.id}/edit`}
                        className="bg-panel border-2 border-border-hard text-text-primary text-xs font-mono font-bold px-2.5 py-1.5 rounded-none shadow-hard block hover:bg-panel-alt"
                    >
                        Estoque
                    </a>
                </div>
            )}

            <div className="flex flex-col sm:flex-row gap-4 mb-5 items-center sm:items-start text-center sm:text-left">
                <div className="w-24 h-36 bg-panel rounded-none overflow-hidden flex-shrink-0 border-2 border-border-hard flex items-center justify-center group-hover:scale-[1.02] transition-transform duration-300 relative shadow-hard">
                    {coverUrl ? (
                        <img src={coverUrl} className="w-full h-full object-cover select-none" alt={book.title} />
                    ) : (
                        <span className="text-[10px] font-mono font-black uppercase tracking-wider text-text-secondary">Sem Capa</span>
                    )}
                </div>

                <div className="flex-1 min-w-0 py-1">
                    <h3 className="font-mono font-black text-text-primary group-hover:text-oak transition-colors duration-200 text-base leading-snug tracking-tight mb-1 capitalize line-clamp-2" title={book.title}>
                        {book.title}
                    </h3>
                    <p className="text-xs font-mono font-bold text-text-secondary truncate capitalize">
                        {book.author?.name || book.author_name || 'Autor desconhecido'}
                    </p>
                </div>
            </div>

            <div className="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t-2 border-border-hard mt-auto">

                <div className="relative z-10 w-full sm:w-auto">
                    {isAuthenticated ? (
                        <form onSubmit={handleToggleReadingList} className="m-0">
                            <Button
                                type="submit"
                                disabled={readingListForm.processing}
                                variant={isSaved ? "primary" : "secondary"}
                                className="w-full"
                            >
                                {isSaved ? 'Guardado' : 'Ler mais tarde'}
                            </Button>
                        </form>
                    ) : (
                        <Link
                            href="/login"
                            className="font-mono text-xs font-bold uppercase select-none outline-none inline-flex items-center justify-center border-2 border-border-hard bg-secondary text-secondary-foreground hover:bg-secondary/90 shadow-hard rounded-none h-10 px-5 gap-2 w-full"
                        >
                            Ler mais tarde
                        </Link>
                    )}
                </div>

                <div className="relative z-10 w-full sm:w-auto text-right">
                    {isAuthenticated ? (
                        <form onSubmit={handleLoan} className="m-0 inline-block w-full sm:w-auto">
                            <Button
                                type="submit"
                                variant={hasActiveLoan ? "secondary" : "primary"}
                                disabled={isLoanButtonDisabled}
                                className="w-full sm:w-auto"
                            >
                                {loanForm.processing ? (
                                    'Processando...'
                                ) : hasActiveLoan ? (
                                    'Emprestado'
                                ) : book.stock > 0 ? (
                                    'Empréstimo'
                                ) : (
                                    'Esgotado'
                                )}
                            </Button>
                        </form>
                    ) : (
                        book.stock > 0 ? (
                            <Link
                                href="/login"
                                className="font-mono text-xs font-bold uppercase select-none outline-none inline-flex items-center justify-center border-2 border-border-hard bg-primary text-primary-foreground hover:bg-primary/90 shadow-hard rounded-none h-10 px-5 gap-2 w-full sm:w-auto"
                            >
                                Empréstimo
                            </Link>
                        ) : (
                            <button
                                disabled
                                className="font-mono text-xs font-bold uppercase select-none border-2 border-border-hard bg-panel text-text-secondary rounded-none h-10 px-5 gap-2 cursor-not-allowed w-full sm:w-auto"
                            >
                                Esgotado
                            </button>
                        )
                    )}
                </div>
            </div>

        </div>
    );
}

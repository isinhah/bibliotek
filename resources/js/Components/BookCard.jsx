import { useForm, usePage, Link } from '@inertiajs/react';
import Button from './Button';

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
        <div className="group bg-white border border-slate-100 rounded-2xl p-4 sm:p-5 flex flex-col justify-between hover:shadow-xl hover:border-slate-200/60 transition-all duration-300 h-full relative">

            {isAdmin && (
                <div className="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                    <a
                        href={`/admin/books/${book.id}/edit`}
                        className="bg-white/90 backdrop-blur-xs text-slate-700 hover:text-[#b91c1c] text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-sm border border-slate-200/60 block"
                    >
                        Estoque
                    </a>
                </div>
            )}

            <div className="flex flex-col sm:flex-row gap-4 mb-5 items-center sm:items-start text-center sm:text-left">
                <div className="w-24 h-36 bg-slate-50 rounded-xl overflow-hidden flex-shrink-0 shadow-sm border border-slate-100 flex items-center justify-center group-hover:scale-[1.02] transition-transform duration-300 relative">
                    {coverUrl ? (
                        <img src={coverUrl} className="w-full h-full object-cover select-none" alt={book.title} />
                    ) : (
                        <span className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Sem Capa</span>
                    )}
                </div>

                <div className="flex-1 min-w-0 py-1">
                    <h3 className="font-extrabold text-slate-900 group-hover:text-[#b91c1c] transition-colors duration-200 text-base leading-snug tracking-tight mb-1 capitalize line-clamp-2" title={book.title}>
                        {book.title}
                    </h3>
                    <p className="text-sm text-slate-500 truncate capitalize font-medium">
                        {book.author?.name || book.author_name || 'Autor desconhecido'}
                    </p>
                </div>
            </div>

            <div className="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-slate-50 mt-auto">

                <div className="relative z-10 w-full sm:w-auto">
                    {!isAdmin && (
                        isAuthenticated ? (
                            <form onSubmit={handleToggleReadingList} className="m-0">
                                <Button type="submit" disabled={readingListForm.processing} variant="secondary" className={`!py-2 !px-3 text-xs rounded-xl w-full ${isSaved ? '!text-emerald-700 !bg-emerald-50 border border-emerald-200/60' : '!text-slate-700 !bg-slate-100 border border-slate-200/50'}`}>
                                    {isSaved ? 'Guardado' : 'Ler mais tarde'}
                                </Button>
                            </form>
                        ) : (
                            <Link href="/login" className="font-medium shadow-sm transition duration-200 focus:outline-none flex items-center justify-center !py-2 !px-3 text-xs rounded-xl w-full text-slate-700 bg-slate-100 border border-slate-200/50 hover:bg-slate-200">
                                Ler mais tarde
                            </Link>
                        )
                    )}
                </div>

                <div className="relative z-10 w-full sm:w-auto text-right">
                    {!isAdmin && (
                        isAuthenticated ? (
                            <form onSubmit={handleLoan} className="m-0 inline-block w-full sm:w-auto">
                                <Button
                                    type="submit"
                                    variant={hasActiveLoan ? "secondary" : "primary"}
                                    disabled={isLoanButtonDisabled}
                                    className={`!py-2 !px-4 text-xs rounded-xl w-full sm:w-auto transition-all ${
                                        hasActiveLoan
                                            ? '!text-slate-400 !bg-slate-100 border border-slate-200/40 cursor-not-allowed'
                                            : ''
                                    }`}
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
                                <Link href="/login" className="font-medium shadow-sm transition duration-200 focus:outline-none flex items-center justify-center bg-slate-950 hover:bg-[#b91c1c] text-white !py-2 !px-4 text-xs rounded-xl w-full sm:w-auto">
                                    Empréstimo
                                </Link>
                            ) : (
                                <button disabled className="inline-flex items-center justify-center bg-slate-100 text-slate-400 font-medium py-2 px-4 rounded-xl text-xs cursor-not-allowed w-full sm:w-auto">
                                    Esgotado
                                </button>
                            )
                            )
                        )}
                </div>
            </div>

        </div>
    );
}

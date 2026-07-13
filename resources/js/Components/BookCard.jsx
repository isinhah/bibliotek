import { useForm, usePage } from '@inertiajs/react';
import Button from './Button';

export default function BookCard({ book, isSaved }) {
    const { auth } = usePage().props;

    const readingListForm = useForm();

    const loanForm = useForm();

    const handleToggleReadingList = (e) => {
        e.preventDefault();
        readingListForm.post(`/reading-list/toggle/${book.id}`, { preserveScroll: true });
    };

    const handleLoan = (e) => {
        e.preventDefault();
        loanForm.post(`/books/${book.id}/loan`, { preserveScroll: true });
    };

    const coverUrl = book.cover_id
        ? (Number.isInteger(Number(book.cover_id))
            ? `https://covers.openlibrary.org/b/id/${book.cover_id}-M.jpg`
            : `/storage/${book.cover_id}`)
        : null;

    return (
        <div className="group bg-white border border-slate-100 rounded-2xl p-4 sm:p-5 flex flex-col justify-between hover:shadow-xl hover:border-slate-200/60 transition-all duration-300 h-full">

            <div className="flex flex-col sm:flex-row gap-4 mb-5 items-center sm:items-start text-center sm:text-left">

                <div className="w-28 h-40 bg-slate-50 flex-shrink-0 rounded-xl overflow-hidden shadow-sm border border-slate-100 relative mx-auto sm:mx-0">
                    {coverUrl ? (
                        <img src={coverUrl} alt={`Capa do livro ${book.title}`} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                    ) : (
                        <div className="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 text-xs">Sem Capa</div>
                    )}
                </div>

                <div className="flex-1 min-w-0">
                    <span className="inline-block text-[10px] font-bold uppercase tracking-widest text-[#b91c1c] bg-red-50 px-2.5 py-1 rounded-bl-xl rounded-tr-xl mb-2">
                        {book.category?.name || 'Geral'}
                    </span>
                    <h3 className="text-base font-bold text-slate-900 tracking-tight leading-snug hover:text-[#b91c1c] transition-colors duration-150 truncate">
                        {book.title}
                    </h3>
                    <p className="text-xs font-semibold text-slate-500 mt-0.5 mb-2 truncate">
                        {book.author?.name || 'Autor Desconhecido'}
                    </p>
                    <p className="text-xs text-slate-400 line-clamp-2 leading-relaxed font-normal">
                        {book.description || 'Sem descrição disponível.'}
                    </p>
                </div>
            </div>

            <div className="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-slate-50 mt-auto">
                <div className="w-full sm:w-auto">
                    {auth?.user && (
                        <form onSubmit={handleToggleReadingList} className="m-0 w-full">
                            {isSaved ? (
                                <Button type="submit" variant="secondary" className="!py-2 !px-3 text-xs rounded-xl w-full !text-emerald-700 !bg-emerald-50 border border-emerald-200/60">
                                    <span>Guardado</span>
                                </Button>
                            ) : (
                                <Button type="submit" variant="secondary" className="!py-2 !px-3 text-xs rounded-xl w-full !text-slate-700 !bg-slate-100 border border-slate-200/50">
                                    Ler mais tarde
                                </Button>
                            )}
                        </form>
                    )}
                </div>

                <div className="relative z-10 w-full sm:w-auto text-right">
                    {book.stock > 0 ? (
                        <form onSubmit={handleLoan} className="m-0 inline-block w-full sm:w-auto">
                            <Button type="submit" variant="primary" className="!py-2 !px-4 text-xs rounded-xl w-full sm:w-auto">
                                Empréstimo
                            </Button>
                        </form>
                    ) : (
                        <button disabled className="inline-flex items-center justify-center bg-slate-100 text-slate-400 font-medium py-2 px-4 rounded-xl text-xs cursor-not-allowed w-full sm:w-auto">
                            Esgotado
                        </button>
                    )}
                </div>
            </div>

        </div>
    );
}

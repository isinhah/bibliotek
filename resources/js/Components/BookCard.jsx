import { useForm, usePage, Link } from '@inertiajs/react';
import { Button } from "@/Components/ui/Button";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/Components/ui/AlertDialog";

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

    const handleConfirmLoan = () => {
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
        <div className="group bg-panel-alt border-2 border-border-hard rounded-none p-4 sm:p-5 flex flex-col justify-between shadow-hard hover:-translate-x-1 hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_rgba(225,29,72,0.15)] hover:border-primary transition-all duration-300 h-full relative">

            {isAdmin && (
                <div className="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                    <a
                        href={`/admin/books/${book.id}/edit`}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="bg-panel border-2 border-border-hard text-text-primary text-xs font-mono font-bold px-2.5 py-1.5 rounded-none shadow-hard block hover:bg-panel-alt"
                    >
                        Estoque
                    </a>
                </div>
            )}

            <div className="flex flex-col sm:flex-row gap-4 mb-5 items-center sm:items-start text-center sm:text-left min-h-[144px]">
                <div className="w-24 h-36 bg-panel rounded-none overflow-hidden flex-shrink-0 border-2 border-border-hard flex items-center justify-center group-hover:scale-[1.02] transition-transform duration-300 relative shadow-hard">
                    {coverUrl ? (
                        <img src={coverUrl} className="w-full h-full object-cover select-none" alt={book.title} />
                    ) : (
                        <span className="text-[10px] font-mono font-black uppercase tracking-wider text-text-secondary">Sem Capa</span>
                    )}
                </div>

                <div className="flex-1 min-w-0 py-1">
                    <h3 className="font-mono font-black text-text-primary group-hover:text-primary transition-colors duration-200 text-base leading-snug tracking-tight mb-1 capitalize line-clamp-2" title={book.title}>
                        {book.title}
                    </h3>
                    <p className="text-xs font-mono font-bold text-text-secondary truncate capitalize">
                        {book.author?.name || book.author_name || 'Autor desconhecido'}
                    </p>
                </div>
            </div>

            <div className="grid grid-cols-2 gap-2 pt-4 border-t-2 border-border-hard mt-auto w-full">

                <div className="relative z-10 w-full flex">
                    {isAuthenticated ? (
                        <form onSubmit={handleToggleReadingList} className="m-0 w-full flex">
                            <Button
                                type="submit"
                                disabled={readingListForm.processing}
                                variant={isSaved ? "primary" : "secondary"}
                                className="w-full text-[10px] sm:text-xs px-2 h-10"
                            >
                                {isSaved ? 'Guardado' : 'Guardar'}
                            </Button>
                        </form>
                    ) : (
                        <Link
                            href="/login"
                            className="group/button inline-flex h-10 px-2 gap-2 shrink-0 items-center justify-center rounded-none border-2 border-border-hard font-mono text-[10px] sm:text-xs font-bold uppercase select-none outline-none active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all bg-secondary text-secondary-foreground hover:bg-secondary/90 shadow-hard w-full text-center"
                        >
                            Guardar
                        </Link>
                    )}
                </div>

                <div className="relative z-10 w-full flex">
                    {isAuthenticated ? (
                        book.stock > 0 && !hasActiveLoan ? (
                            <AlertDialog>
                                <AlertDialogTrigger asChild>
                                    <Button
                                        variant="primary"
                                        className="w-full text-[10px] sm:text-xs px-2 h-10"
                                    >
                                        Empréstimo
                                    </Button>
                                </AlertDialogTrigger>

                                <AlertDialogContent className="max-w-md">
                                    <AlertDialogHeader className="flex flex-col items-center justify-center text-center w-full">
                                        <AlertDialogTitle className="text-center w-full">
                                            Confirmar Empréstimo?
                                        </AlertDialogTitle>
                                        <AlertDialogDescription className="text-center w-full leading-relaxed">
                                            Você deseja pedir emprestado o livro <span className="text-primary capitalize">"{book.title}"</span>?
                                        </AlertDialogDescription>
                                    </AlertDialogHeader>

                                    <AlertDialogFooter className="grid grid-cols-2 gap-3 w-full mt-4 sm:flex-row sm:justify-stretch">
                                        <AlertDialogCancel className="w-full m-0">
                                            Cancelar
                                        </AlertDialogCancel>
                                        <AlertDialogAction onClick={handleConfirmLoan} className="w-full m-0">
                                            Confirmar
                                        </AlertDialogAction>
                                    </AlertDialogFooter>
                                </AlertDialogContent>
                            </AlertDialog>
                        ) : (
                            <div className="w-full">
                                <Button
                                    disabled
                                    variant={hasActiveLoan ? "secondary" : "outline"}
                                    className="w-full text-[10px] sm:text-xs px-2 h-10 opacity-50 cursor-not-allowed"
                                >
                                    {hasActiveLoan ? 'Emprestado' : 'Esgotado'}
                                </Button>
                            </div>
                        )
                    ) : (
                        book.stock > 0 ? (
                            <Link
                                href="/login"
                                className="group/button inline-flex h-10 px-2 gap-2 shrink-0 items-center justify-center rounded-none border-2 border-border-hard font-mono text-[10px] sm:text-xs font-bold uppercase select-none outline-none active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all bg-primary text-primary-foreground hover:bg-primary/90 shadow-hard w-full text-center"
                            >
                                Empréstimo
                            </Link>
                        ) : (
                            <Button
                                disabled
                                variant="outline"
                                className="w-full text-[10px] sm:text-xs px-2 h-10 opacity-50 cursor-not-allowed"
                            >
                                Esgotado
                            </Button>
                        )
                    )}
                </div>
            </div>

        </div>
    );
}

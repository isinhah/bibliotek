import React from 'react';
import {
    AlertDialog,
    AlertDialogContent,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogFooter,
    AlertDialogCancel,
} from "@/Components/ui/AlertDialog";

export default function BookDetailsModal({ book, isOpen, onClose }) {
    if (!book) return null;

    const coverUrl = book.cover_id
        ? (Number.isInteger(Number(book.cover_id))
            ? `https://covers.openlibrary.org/b/id/${book.cover_id}-M.jpg`
            : `/storage/${book.cover_id}`)
        : null;

    return (
        <AlertDialog open={isOpen} onOpenChange={onClose}>
            <AlertDialogContent className="max-w-lg p-6 sm:p-7">

                <AlertDialogHeader className="border-b-2 border-border-hard pb-3 mb-4">
                    <AlertDialogTitle className="text-base sm:text-lg md:text-xl leading-tight font-black break-words capitalize">
                        {book.title}
                    </AlertDialogTitle>
                    <p className="text-[11px] sm:text-xs font-mono font-bold text-primary/80 uppercase tracking-wide capitalize break-words flex items-center gap-1">
                        <span className="opacity-60">✎</span>
                        {book.author?.name || book.author_name || 'Autor Desconhecido'}
                    </p>
                </AlertDialogHeader>

                <div className="flex flex-col sm:flex-row gap-5 items-center sm:items-start my-2">
                    <div className="w-28 h-40 bg-panel rounded-none flex-shrink-0 border-2 border-border-hard flex items-center justify-center shadow-hard relative">
                        <div className="w-full h-full overflow-hidden">
                            {coverUrl ? (
                                <img src={coverUrl} alt={book.title} className="w-full h-full object-cover select-none" />
                            ) : (
                                <span className="text-[10px] font-mono font-black uppercase text-text-secondary px-2 text-center block">Sem Capa</span>
                            )}
                        </div>

                        {book.rating && (
                            <div className="absolute -bottom-2 -right-2 bg-primary border-2 border-border-hard text-[11px] font-mono font-black px-2 py-1 shadow-hard text-primary-foreground flex items-center gap-1 rotate-2">
                                <span className="text-xs leading-none">⭐</span>
                                <span className="leading-none">{Number(book.rating).toFixed(1)}</span>
                            </div>
                        )}
                    </div>

                    <div className="flex-1 w-full space-y-2 text-[11px] sm:text-xs font-mono min-w-0">

                        <div className="flex flex-wrap justify-between items-center p-2 bg-panel-alt border border-border-hard gap-1 hover:border-primary transition-colors duration-200">
                            <span className="font-bold uppercase text-text-secondary flex items-center gap-1">
                                Publicação:
                            </span>
                            <span className="font-black text-text-primary break-words text-right">{book.publish_date ?? '-'}</span>
                        </div>

                        <div className="flex flex-wrap justify-between items-center p-2 bg-panel-alt border border-border-hard gap-1 hover:border-primary transition-colors duration-200">
                            <span className="font-bold uppercase text-text-secondary flex items-center gap-1">
                                Editora:
                            </span>
                            <span className="font-black text-text-primary break-words text-right max-w-full">
                                {book.publisher ?? '-'}
                            </span>
                        </div>

                        <div className="flex flex-wrap justify-between items-center p-2 bg-panel-alt border border-border-hard gap-1 hover:border-primary transition-colors duration-200">
                            <span className="font-bold uppercase text-text-secondary flex items-center gap-1">
                                Páginas:
                            </span>
                            <span className="font-black text-text-primary break-words text-right">{book.pages ?? '-'}</span>
                        </div>

                    </div>
                </div>

                <AlertDialogFooter className="mt-6 border-t-2 border-border-hard pt-4">
                    <AlertDialogCancel onClick={onClose} className="w-full sm:w-auto font-mono font-bold uppercase text-xs">
                        Fechar
                    </AlertDialogCancel>
                </AlertDialogFooter>

            </AlertDialogContent>
        </AlertDialog>
    );
}

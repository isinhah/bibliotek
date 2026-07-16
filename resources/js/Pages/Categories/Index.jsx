import { Link } from '@inertiajs/react';
import Layout from '../../Layouts/Layout';

export default function Index({ categories }) {
    const categoriesData = categories.data || categories || [];

    return (
        <>
            <div className="mb-12 text-center sm:text-left pb-6 border-b-2 border-border-hard flex flex-col sm:flex-row justify-between items-center sm:items-end gap-4">
                <div>
                    <h1 className="text-sm sm:text-base font-minecraft font-black text-text-primary uppercase tracking-wider flex items-center justify-center sm:justify-start gap-3 [text-shadow:2px_2px_0_rgba(0,0,0,0.8)]">
                        <span className="w-2.5 h-8 bg-oak border-2 border-border-hard rounded-none"></span>
                        Categorias
                    </h1>
                    <p className="text-text-secondary mt-2 max-w-xl text-sm font-mono font-semibold">
                        Navegue pelas prateleiras do nosso acervo e encontre sua próxima leitura.
                    </p>
                </div>
            </div>

            {categoriesData.length === 0 ? (
                <div className="text-center py-24 bg-panel-alt border-2 border-border-hard rounded-none shadow-hard max-w-lg mx-auto">
                    <span className="text-4xl block mb-4">🗂️</span>
                    <p className="text-text-primary font-mono font-bold text-sm">
                        Nenhuma categoria com livros disponível no momento.
                    </p>
                </div>
            ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    {categoriesData.map((category) => (
                        <Link
                            key={category.id}
                            href={`/categories/${category.id}/books`}
                            className="group relative flex flex-col justify-between h-32 p-5 bg-panel-alt text-text-primary border-2 border-border-hard shadow-hard hover:-translate-x-1 hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_rgba(225,29,72,0.15)] hover:border-primary transition-all duration-300 rounded-none overflow-hidden"
                        >
                            <div className="flex items-start gap-4 min-w-0 relative z-10">
                                <div className="w-10 h-10 shrink-0 flex items-center justify-center text-xl select-none transform group-hover:rotate-12 transition-transform duration-200 ease-out">
                                    🗝️
                                </div>

                                <div className="min-w-0 flex-1 py-0.5">
                                    <h3 className="font-mono font-black uppercase text-base tracking-tight truncate capitalize group-hover:text-primary transition-colors duration-200">
                                        {category.name}
                                    </h3>

                                    <span className="inline-flex items-center text-xs font-mono font-bold text-text-secondary mt-1">
                                        <span className="w-1.5 h-1.5 bg-oak border border-border-hard mr-2 rounded-none group-hover:bg-primary transition-colors duration-200"></span>
                                        {category.books_count} {category.books_count === 1 ? 'livro catalogado' : 'livros catalogados'}
                                    </span>
                                </div>
                            </div>

                            <div className="flex justify-end relative z-10">
                                <span className="text-xs font-mono font-bold text-text-secondary group-hover:text-primary transition-all duration-200 flex items-center gap-1">
                                    Explorar
                                    <span className="inline-block transform group-hover:translate-x-1 transition-transform duration-200">
                                        →
                                    </span>
                                </span>
                            </div>
                        </Link>
                    ))}
                </div>
            )}

            {categories.links && categoriesData.length > 0 && (
                <div className="mt-12 flex justify-between items-center bg-panel px-6 py-4 rounded-none border-2 border-border-hard shadow-hard">
                    {categories.prev_page_url ? (
                        <Link
                            href={categories.prev_page_url}
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
                        Pág. {categories.current_page} de {categories.last_page}
                    </span>

                    {categories.next_page_url ? (
                        <Link
                            href={categories.next_page_url}
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

Index.layout = page => <Layout children={page} title="Categorias" />

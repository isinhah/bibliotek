import { Link } from '@inertiajs/react';
import Layout from '../../Layouts/Layout';

export default function Index({ categories }) {
    return (
        <>
            <div className="mb-12 text-center sm:text-left pb-6 border-b-2 border-border-hard flex flex-col sm:flex-row justify-between items-center sm:items-end gap-4">
                <div>
                    <h1 className="text-3xl sm:text-4xl font-mono font-black text-text-primary tracking-tight flex items-center justify-center sm:justify-start gap-3">
                        <span className="w-2.5 h-8 bg-oak border-2 border-border-hard rounded-xs"></span>
                        Categorias
                    </h1>
                    <p className="text-text-secondary mt-2 max-w-xl text-sm font-mono font-semibold">
                        Encontre o seu próximo livro navegando pelos seus temas favoritos.
                    </p>
                </div>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                {categories.map((category) => (
                    <Link
                        key={category.id}
                        href={`/categories/${category.id}/books`}
                        className="group bg-panel p-6 rounded-xl border-2 border-border-hard shadow-hard hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[6px_6px_0px_0px_#000000] transition-all duration-200 flex justify-between items-center h-full"
                    >
                        <div className="space-y-2 min-w-0">
                            <h3 className="font-mono font-black text-text-primary group-hover:text-primary transition-colors duration-200 capitalize text-lg tracking-tight truncate">
                                {category.name}
                            </h3>

                            <span className="inline-flex items-center text-xs font-mono font-bold text-text-secondary">
                                <span className="w-2 h-2 bg-oak-light border border-border-hard mr-2 group-hover:bg-oak transition-colors duration-200"></span>
                                {category.books_count} {category.books_count === 1 ? 'livro disponível' : 'livros disponíveis'}
                            </span>
                        </div>

                        <span className="w-8 h-8 rounded-lg border-2 border-border-hard bg-panel-alt text-text-primary flex items-center justify-center font-mono font-black text-sm group-hover:bg-primary group-hover:text-primary-foreground group-hover:shadow-[2px_2px_0px_0px_#000000] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all">
                            →
                        </span>
                    </Link>
                ))}
            </div>
        </>
    );
}

Index.layout = page => <Layout children={page} title="Categorias" />

import { Link } from '@inertiajs/react';
import Layout from '../../Layouts/Layout';

export default function Index({ categories }) {
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

            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                {categories.map((category) => (
                    <Link
                        key={category.id}
                        href={`/categories/${category.id}/books`}
                        className="group relative flex flex-col justify-between h-36 p-6 bg-panel-alt text-text-primary border-2 border-border-hard shadow-hard hover:-translate-x-1 hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,0.8)] hover:border-primary hover:shadow-primary/20 transition-all duration-300 rounded-none overflow-hidden"
                    >
                        <div
                            className="absolute inset-0 opacity-[0.06] pointer-events-none"
                            style={{
                                backgroundImage:
                                    'linear-gradient(currentColor 1px, transparent 1px), linear-gradient(90deg, currentColor 1px, transparent 1px)',
                                backgroundSize: '12px 12px',
                            }}
                        />

                        <div className="space-y-1.5 min-w-0 relative z-10">
                            <h3 className="font-mono font-black uppercase text-lg tracking-tight truncate capitalize group-hover:text-primary transition-colors duration-200">
                                {category.name}
                            </h3>

                            <span className="inline-flex items-center text-xs font-mono font-bold text-text-secondary">
                                <span className="w-2 h-2 bg-oak border border-border-hard mr-2 rounded-none"></span>
                                {category.books_count} {category.books_count === 1 ? 'livro' : 'livros'}
                            </span>
                        </div>

                        <div className="flex justify-end relative z-10">
                            <span className="w-8 h-8 border-2 border-border-hard bg-panel text-text-primary flex items-center justify-center font-mono font-black text-sm group-hover:bg-primary group-hover:text-primary-foreground group-hover:shadow-[2px_2px_0px_0px_#000000] transition-all duration-200">
                                🗂️
                            </span>
                        </div>
                    </Link>
                ))}
            </div>
        </>
    );
}

Index.layout = page => <Layout children={page} title="Categorias" />

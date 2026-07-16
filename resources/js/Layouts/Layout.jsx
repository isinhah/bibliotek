import { Head, Link, usePage } from '@inertiajs/react'
import Alert from "../Components/Alert.jsx";
import { Button } from '@/Components/ui/Button';

export default function Layout({ children, title, isHome = false }) {
    const { auth } = usePage().props || {}
    const isAdmin = auth?.user?.role === 'admin';

    return (
        <>
            <Head title={isHome ? 'Bibliotek' : (title ? `${title} — Bibliotek` : 'Bibliotek')} />

            <nav className="bg-panel border-b-2 border-border-hard relative z-50">
                <div className="container mx-auto px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">

                    <div className="flex items-center gap-8 w-full sm:w-auto">
                        <Link
                            href="/"
                            className="font-minecraft text-sm sm:text-base uppercase tracking-tight text-text-primary hover:text-oak transition-colors duration-150 [text-shadow:2px_2px_0_rgba(0,0,0,0.8)]"
                        >
                            Bibliotek<span className="text-primary">.</span>
                        </Link>

                        <div className="hidden md:flex items-center gap-6 text-xs font-bold uppercase tracking-wide text-text-secondary">
                            <Link href="/categories" className="hover:text-oak transition-colors duration-150">Categorias</Link>
                            <Link href="/authors" className="hover:text-oak transition-colors duration-150">Autores</Link>

                            {auth?.user && (
                                <>
                                    {isAdmin ? (
                                        <a
                                            href="/admin"
                                            className="text-warning hover:text-warning/80 font-minecraft text-[10px] tracking-wider transition-colors duration-150 flex items-center gap-1.5 border-l-2 border-border-hard pl-6 [text-shadow:1px_1px_0_rgba(0,0,0,0.5)]"
                                        >
                                            <span className="w-1.5 h-1.5 rounded-full bg-warning animate-pulse"></span>
                                            Painel Admin
                                        </a>
                                    ) : (
                                        <div className="flex items-center gap-6 border-l-2 border-border-hard pl-6">
                                            <a href="/reader" className="hover:text-oak transition-colors duration-150">
                                                Minha Biblioteca
                                            </a>
                                            <a href="/reader/reading-list" className="hover:text-oak transition-colors duration-150">
                                                Lista de Leitura
                                            </a>
                                        </div>
                                    )}
                                </>
                            )}
                        </div>
                    </div>

                    <div className="flex items-center gap-4 w-full sm:w-auto justify-center sm:justify-end">
                        {auth?.user ? (
                            <>
                                <span className="text-xs font-mono font-black uppercase tracking-wider text-text-primary truncate max-w-[150px]">
                                    {auth.user.name}
                                </span>

                                <a href={isAdmin ? "/admin/profile" : "/reader/profile"} className="text-text-secondary hover:text-text-primary transition-colors duration-150 p-1.5 rounded-none hover:bg-panel-alt/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </a>

                                <Link
                                    href="/logout"
                                    method="post"
                                    as="button"
                                    title="Sair da Conta"
                                    className="text-text-secondary hover:text-danger transition-colors duration-150 p-1.5 rounded-none hover:bg-panel-alt/30"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                    </svg>
                                </Link>
                            </>
                        ) : (
                            <>
                                <Link
                                    href="/login"
                                    className="text-xs font-mono font-bold uppercase tracking-wide text-text-secondary hover:text-text-primary transition-colors duration-150 px-3 py-2"
                                >
                                    Entrar
                                </Link>
                                <Link href="/register">
                                    <Button variant="primary" size="sm">
                                        Criar conta
                                    </Button>
                                </Link>
                            </>
                        )}
                    </div>
                </div>
            </nav>

            <Alert />

            <div className="min-h-screen bg-page text-text-primary flex flex-col pt-1 overflow-hidden">
                {isHome ? (
                    <div className="flex-1">{children}</div>
                ) : (
                    <main className="container mx-auto my-8 px-6 flex-1">
                        {children}
                    </main>
                )}
            </div>
        </>
    )
}

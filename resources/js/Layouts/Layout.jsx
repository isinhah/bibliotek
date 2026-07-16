import { Head, Link, usePage } from '@inertiajs/react'
import Alert from "../Components/Alert.jsx";
import { Button } from '@/Components/ui/Button';

export default function Layout({ children, title, isHome = false }) {
    const { auth } = usePage().props || {}
    const isAuthenticated = !!auth?.user;
    const isAdmin = auth?.user?.role === 'admin';
    const profileUrl = isAdmin ? '/admin/profile' : '/reader/profile';

    return (
        <>
            <Head title={isHome ? 'Bibliotek' : (title ? `${title} — Bibliotek` : 'Bibliotek')} />

            <nav className="bg-panel border-b-2 border-border-hard relative z-50 h-auto sm:h-[72px] flex items-center">
                <div className="container mx-auto px-6 py-4 sm:py-0 flex flex-col sm:flex-row justify-between items-center gap-4 w-full">

                    <div className="flex items-center gap-8 w-full sm:w-auto">
                        <Link
                            href="/"
                            className="font-minecraft text-sm sm:text-base uppercase tracking-tight text-text-primary hover:text-primary transition-colors duration-150 [text-shadow:2px_2px_0_rgba(0,0,0,0.8)]"
                        >
                            Bibliotek<span className="text-primary">.</span>
                        </Link>

                        <div className="hidden md:flex items-center gap-6 text-xs font-bold uppercase tracking-wide text-text-secondary">

                            <Link href="/categories" className="hover:text-text-primary transition-colors duration-150">
                                Categorias
                            </Link>
                            <Link href="/authors" className="hover:text-text-primary transition-colors duration-150">
                                Autores
                            </Link>

                            {isAuthenticated && (
                                <>
                                    <span className="text-border-hard/20 select-none">|</span>

                                    <a
                                        href="/reader/loans"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="inline-flex items-center gap-2 hover:text-text-primary transition-colors duration-150"
                                    >
                                        <span className="w-2 h-2 bg-oak border border-border-hard rounded-none shrink-0" />
                                        Meus Empréstimos
                                    </a>

                                    <a
                                        href="/reader/reading-list"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="inline-flex items-center gap-2 hover:text-text-primary transition-colors duration-150"
                                    >
                                        <span className="w-2 h-2 bg-primary border border-border-hard rounded-none shrink-0" />
                                        Lista de Leitura
                                    </a>
                                </>
                            )}
                        </div>
                    </div>

                    <div className="flex items-center gap-3 w-full sm:w-auto justify-end h-9">
                        {auth?.user ? (
                            <>
                                <span className="text-xs font-mono font-bold text-text-secondary hidden sm:flex items-center h-full">
                                    OLÁ, <span className="text-text-primary ml-1 uppercase">{auth.user.name}</span>
                                </span>

                                {isAdmin && (
                                    <a
                                        href="/admin"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="inline-flex items-center justify-center gap-2 border-2 border-border-hard bg-panel-alt text-text-primary px-3 h-9 text-xs font-bold uppercase tracking-wide shadow-hard hover:bg-secondary hover:text-secondary-foreground transition-all duration-150 rounded-none shrink-0 select-none"
                                    >
                                        <span className="w-1.5 h-1.5 bg-warning border border-border-hard rounded-none shrink-0 animate-pulse" />
                                        Painel Admin
                                    </a>
                                )}

                                <a
                                    href={profileUrl}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="Editar Perfil"
                                    className="border-2 border-border-hard bg-panel-alt text-text-primary h-9 w-9 transition-colors duration-150 shadow-hard hover:bg-secondary hover:text-secondary-foreground flex items-center justify-center rounded-none shrink-0"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2.5} stroke="currentColor" className="w-4 h-4">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </a>

                                <Link
                                    href="/logout"
                                    method="post"
                                    as="button"
                                    aria-label="Sair"
                                    className="border-2 border-border-hard bg-panel-alt text-text-primary h-9 w-9 transition-colors duration-150 shadow-hard hover:bg-danger hover:text-danger-foreground flex items-center justify-center rounded-none shrink-0"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2.5} stroke="currentColor" className="w-4 h-4">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                    </svg>
                                </Link>
                            </>
                        ) : (
                            <>
                                <Link
                                    href="/login"
                                    className="text-xs font-mono font-bold uppercase tracking-wide text-text-secondary hover:text-text-primary transition-colors duration-150 px-3 h-9 flex items-center"
                                >
                                    Entrar
                                </Link>

                                <Link href="/register">
                                    <Button variant="primary" className="h-9 rounded-none text-xs">
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

import { useForm, Link } from '@inertiajs/react'
import Layout from '../../Layouts/Layout.jsx'
import { Button } from "@/Components/ui/Button.jsx";

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
    })

    function submit(e) {
        e.preventDefault()
        post('/login', {
            preserveScroll: true
        })
    }

    return (
        <div className="max-w-md mx-auto bg-panel-alt p-8 sm:p-10 rounded-none border-2 border-border-hard shadow-hard mt-16 font-mono">
            <h2 className="text-xs sm:text-sm font-minecraft font-black text-text-primary mb-8 text-center uppercase tracking-wider flex items-center justify-center gap-2.5 [text-shadow:2px_2px_0_rgba(0,0,0,0.8)]">
                <span className="w-2.5 h-2.5 bg-primary border border-border-hard shrink-0 animate-pulse"></span>
                Acesse sua conta
            </h2>

            <form onSubmit={submit} noValidate>
                <div className="mb-5">
                    <label className="block text-text-secondary text-xs font-bold uppercase tracking-wider mb-2">
                        E-mail
                    </label>
                    <input
                        type="email"
                        name="email"
                        value={data.email}
                        onChange={e => setData('email', e.target.value)}
                        className={`w-full px-4 py-3 bg-panel border-2 text-sm text-text-primary outline-none focus:ring-2 focus:ring-primary focus:border-border-hard rounded-none transition-all ${
                            errors.email ? 'border-danger' : 'border-border-hard'
                        }`}
                    />
                    {errors.email && (
                        <span className="text-danger text-xs mt-1.5 block font-bold">
                            ✕ {errors.email}
                        </span>
                    )}
                </div>

                <div className="mb-8">
                    <label className="block text-text-secondary text-xs font-bold uppercase tracking-wider mb-2">
                        Senha
                    </label>
                    <input
                        type="password"
                        name="password"
                        value={data.password}
                        onChange={e => setData('password', e.target.value)}
                        className={`w-full px-4 py-3 bg-panel border-2 text-sm text-text-primary outline-none focus:ring-2 focus:ring-primary focus:border-border-hard rounded-none transition-all ${
                            errors.password ? 'border-danger' : 'border-border-hard'
                        }`}
                    />

                    {errors.password && (
                        <span className="text-danger text-xs mt-1.5 block font-bold">
                            ✕ {errors.password}
                        </span>
                    )}
                </div>

                <Button
                    type="submit"
                    disabled={processing}
                    variant="primary"
                    className="w-full h-12 mb-6"
                >
                    {processing ? 'Entrando...' : 'Entrar'}
                </Button>

                <p className="text-center text-xs font-bold text-text-secondary">
                    Não tem uma conta?
                    <Link
                        href="/register"
                        className="text-primary hover:underline underline-offset-4 ml-1"
                    >
                        Cadastre-se
                    </Link>
                </p>
            </form>
        </div>
    )
}

Login.layout = page => <Layout children={page} title="Entrar" />

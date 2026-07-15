import { Link, useForm } from '@inertiajs/react'
import Layout from '../../Layouts/Layout.jsx'
import { Button } from "@/Components/ui/Button.jsx";

export default function Register() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    })

    function submit(e) {
        e.preventDefault()
        post('/register')
    }

    return (
        <div className="max-w-md mx-auto bg-panel-alt p-8 sm:p-10 rounded-none border-2 border-border-hard shadow-hard mt-10 font-mono">
            <h2 className="text-2xl sm:text-3xl font-black text-text-primary mb-8 text-center uppercase tracking-tight flex items-center justify-center gap-2.5">
                <span className="w-3.5 h-3.5 bg-primary border border-border-hard shrink-0 animate-pulse"></span>
                Crie sua conta
            </h2>

            <form onSubmit={submit}>
                <div className="mb-5">
                    <label className="block text-text-secondary text-xs font-bold uppercase tracking-wider mb-2">
                        Nome Completo
                    </label>
                    <input
                        type="text"
                        value={data.name}
                        onChange={e => setData('name', e.target.value)}
                        className="w-full px-4 py-3 bg-panel border-2 border-border-hard text-sm text-text-primary outline-none focus:ring-2 focus:ring-primary focus:border-border-hard rounded-none transition-all"
                        required
                    />
                </div>

                <div className="mb-5">
                    <label className="block text-text-secondary text-xs font-bold uppercase tracking-wider mb-2">
                        E-mail
                    </label>
                    <input
                        type="email"
                        value={data.email}
                        onChange={e => setData('email', e.target.value)}
                        className={`w-full px-4 py-3 bg-panel border-2 text-sm text-text-primary outline-none focus:ring-2 focus:ring-primary focus:border-border-hard rounded-none transition-all ${
                            errors.email ? 'border-danger' : 'border-border-hard'
                        }`}
                        required
                    />
                    {errors.email && (
                        <span className="text-danger text-xs mt-1.5 block font-bold">
                            ✕ {errors.email}
                        </span>
                    )}
                </div>

                <div className="mb-5">
                    <label className="block text-text-secondary text-xs font-bold uppercase tracking-wider mb-2">
                        Senha
                    </label>
                    <input
                        type="password"
                        value={data.password}
                        onChange={e => setData('password', e.target.value)}
                        className={`w-full px-4 py-3 bg-panel border-2 text-sm text-text-primary outline-none focus:ring-2 focus:ring-primary focus:border-border-hard rounded-none transition-all ${
                            errors.password ? 'border-danger' : 'border-border-hard'
                        }`}
                        required
                    />
                    {errors.password && (
                        <span className="text-danger text-xs mt-1.5 block font-bold">
                            ✕ {errors.password}
                        </span>
                    )}
                </div>

                <div className="mb-8">
                    <label className="block text-text-secondary text-xs font-bold uppercase tracking-wider mb-2">
                        Confirme a Senha
                    </label>
                    <input
                        type="password"
                        value={data.password_confirmation}
                        onChange={e => setData('password_confirmation', e.target.value)}
                        className="w-full px-4 py-3 bg-panel border-2 border-border-hard text-sm text-text-primary outline-none focus:ring-2 focus:ring-primary focus:border-border-hard rounded-none transition-all"
                        required
                    />
                </div>

                <Button
                    type="submit"
                    disabled={processing}
                    variant="primary"
                    className="w-full h-12 mb-6"
                >
                    {processing ? 'Criando...' : 'Criar Conta'}
                </Button>

                <p className="text-center text-xs font-bold text-text-secondary">
                    Já possui uma conta?
                    <Link
                        href="/login"
                        className="text-primary hover:underline underline-offset-4 ml-1"
                    >
                        Fazer Login
                    </Link>
                </p>
            </form>
        </div>
    )
}

Register.layout = page => <Layout children={page} title="Criar conta" />

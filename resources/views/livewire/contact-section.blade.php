<div>
    <section class="contact-section spad" id="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title contact-title">
                        <span>Contact Us</span>
                        <h2>GET IN TOUCH</h2>
                    </div>
                    <div class="contact-widget">
                        <div class="cw-text">
                            <i class="fa fa-map-marker"></i>
                            <p>Zone 5, AFP Housing </br>
                                Bulihan, Silang, Cavite</p>
                        </div>
                        <div class="cw-text">
                            <i class="fa fa-mobile"></i>
                            <ul>
                                <li>0912 123 6182</li>
                            </ul>
                        </div>
                        <div class="cw-text email">
                            <i class="fa fa-envelope"></i>
                            <p>jeremiahpanganibanr@gmail.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="leave-comment">
                        <form wire:submit.prevent="submit">
                            @if (session()->has('message'))
                                <div class="alert alert-success mb-3">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <input type="text" placeholder="Name" wire:model.defer="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input type="text" placeholder="Email" wire:model.defer="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <textarea placeholder="Message" wire:model.defer="message"></textarea>
                            @error('message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <button type="submit" wire:loading.attr="disabled" wire:target="submit">
                                <span wire:loading.remove wire:target="submit">Submit</span>
                                <span wire:loading wire:target="submit">
                                    <i class="fa fa-spinner fa-spin"></i> Submitting...
                                </span>
                            </button>
                        </form>
                        <br>
                        @if (session()->has('success-message'))
                            <div x-data="{ show: true }" x-init="$watch('show', value => {
                                if (!value) $el.remove(); // Remove element when hidden
                            });
                            setTimeout(() => show = false, 10000);" x-show="show"
                                class="alert alert-success">
                                {{ session('success-message') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div style="width: 100%; height: 550px; display: block;">
                <iframe
                    src= "https://www.google.com/maps/embed?pb=!4v1749006694006!6m8!1m7!1s_lySX1LpeX_ZrG_RdmzmYQ!2m2!1d14.27913047940936!2d120.9969352804435!3f109.56204!4f0!5f0.7820865974627469" width="1200" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
</div>

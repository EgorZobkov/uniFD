<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Delivery;

class Dostavista
{
    public $alias = "dostavista";
    public $data;

    public function __construct(){
        global $app;
        $this->data = $this->getData();
    }

    private function getData(){
        global $app;
        $data = $app->model->system_delivery_services->find("alias=?", [$this->alias]);
        if ($data) {
            $data->params = (object)_json_decode(decrypt($data->params));
            return $data;
        }
        return null;
    }

    public function logo(){
        global $app;

        if (!$app->storage->name($this->data->image)->exist()) {
            return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAANgAAADYCAYAAACJIC3tAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAydpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMS1jMDAyIDc5LmE2YTYzOTY4YSwgMjAyNC8wMy8wNi0xMTo1MjowNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDI1LjExIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo0RkNDQzEyQ0E1MTgxMUYwODY3MEVCQjlFRUQ0REYzQyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo0RkNDQzEyREE1MTgxMUYwODY3MEVCQjlFRUQ0REYzQyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjRGQ0NDMTJBQTUxODExRjA4NjcwRUJCOUVFRDRERjNDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjRGQ0NDMTJCQTUxODExRjA4NjcwRUJCOUVFRDRERjNDIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+rYnztQAAKPBJREFUeNrsfQt0VGWW7q5KJeGVB+g14SX0hRAQhKAEsBUIcEXsaXmjM16U54w9ok17x7VU7G4bb4P2WtODCK6ZtVoJIHfmAiqo0y3S0kLsbiTQAs4ICeBtlACh2x5DAkKAJPd8VXUqp16nztnnnKpTlf2tVStVlUrVyan/O3vvbz9+DyUR48eP75+VlVXm9XoL29ra+ilP4Wehx+MpxH3cgvdDwO+DvxMIItGgrJeGiPVySns/+Hu87gv18e7duw8n6wA9TpIpOzu7orW1dYLyT5UpT5XJehC4CIeVdYnbHuWCv3fXrl2nXE8whVSFPp/vB8rdCcqtQr5DQZoRboPiYb1tJ9lsIdiUKVP6t7S0PKeY4AV6r2u5fp2U1wV+Kre2tlZqvd4CU06KpfP/bFF+hqFVeV1rm3z9gujF61WWr9cX9pwvKyt0XyGL8uss8ni8lOXzBW7Kc/ip+74Boq2wg2iWCAaLpRzIT5QDWhb5uzaFKNeuXaPmy9/QteardP1asxBF4Bpi+rJzKTs3h3I7d6Gc3FzHiMYm2MSJE2coB1AZKUBcbW6my01N1HzlGyGUIG0Il9ulC3XumhdFNmWNQxj5yQcffLAxKQSLZ7VArIsNDYq1uiLfmCBtAfcx/4Ybo4jm9Xpfunr16oqqqqoGxwiGWOv69evbSaMIIpa68Je/CLEEGYVO3bpSt/zCsHgN1kwxLhPNuIyGCTZ58mSQantbW1t/9blLjY3KrUFcQUHGWrOu+QXUuVs3Nsk8RsmlEOtDbbzV9PXX9E1To3wLgoxHl/x8yivsrn0KieuJRhLWCQkWdAsPqeSCOvj1n87TtatX5cwLOgyylZisQInNNC6jIZJ5E5GrpaUlZLkQb/2l/pyQS9DhcK252W9YwIEgwInt4AjLgkEtzM7OPqTGXHjjiA8QCDpkXHZDz16IxdSnDise3sR46mLclDakeK2gceGrPwu5OjB6eHOouyeXvpXVjfort0LlfoE3O/T7Ak+O8jinQ5yLS98Qrej6pfqwLCcn5znl5xOGLdjkyZMXKOSqFEGjYxLpdt8NNEK53ZrdnW71daccX56yUrLl5GiwP6uOlmedCD1W+DLzww8/3JGQYGrcpVqvyxcvUuN//UXOaAYTalZuPxru60GTOt2suC5d5aQYxBtZJ+mfs06HRA/FVfxWpKsY5SIGi3ZDcdelxgtyJjMMA7LyaEGXgTQuu5huzCmSE8LEnNb+9L73z/T/PP4ii8JYrqIn0nopLPxjKO76r6/oysVLciYzxFI90XWokMpmXPA20CzfoXaL5fN9S5uE9kVaL/U+aguFXOmPu3N60rPdyoRUDqGgtZDGt3WnKs/XWg4tjLJgkdbrq7NnRDVMc2s1s9NAialSYMUUHnVXYzGvxnpN11ovIVd6Eut/542kqv82l2Z2HSHkSrIV07iJoU6TEMG03ciXLzXJWUtnYomknnTMbSnWPqwII1iw3CPUgtL8zTdyxtIEs3P7UdUN04VYKcYtbTdSj7bQ+a9Q0C9EMMU9rNC6h9J+4n7cnn0j7elxL63oPlFcQTegzUfDKKytpULrIk4Q65Ve7uDGG74ryqDLMLX1xig30ReMv0LuoVTKu9tqbSwUi+VWDG4Ls2BlIYJp4y9MfxK4D092GUYL8kfJiXAxCjQEUznlDY4C8MM/q1DiL9e5hIi1hFzpEYd9q61Tu49YUdHPG5z9HiBYS4ucJJe5hFAIJdZKH/SlzqH7Xq+3zKf4iv0xUVe1YAJ3YHHnEnoif7RI72mGm9tyQ/VRMF6+4C4nQjAXASqhP68lSDv0aWu3YDBeEDlCLmJb5Fx4QdKxsXAc3d5pgJyINEV+eP18oVe7H1drm8RgqQLEDCFX+iOvrZ1gqovYP+QiXhOCpYpcH3SfSjnZPeRkZJAFg/HyyikRcglstGCRLqKcktRifcF4IVcmEwxKRygGkzxYUoGYa2BuHzkRGQRvRAwmFixFgBQvgkYHIJycgtSQS/JcQjCBA0CDpJCrI7mMmlrE1lap5HASA3x5tALlT4IMRrRMr6nkkEp6J/F296nSy5XpaBOZPiV4OX+skEtiMIETWNK5hCZ1GSwnQggmcCLu+kG3MjkRQjCBE/hx1zJxDYVgAqdcw9s7SzJZCCYQ11AgBBPXUCAEE/itl7iGAiGYQ/h53hg5CQIhmBOYm9tfWlAEQjCn8Fx+uZwEQQg+OQX2AbK8CBsZhrxORCXFgRtw4hzRJ18IwVIBkeUzhFDfUb7HkTcTDSwiKiqIfs3vjhOt2UV0rkEIlixgs3GxXmmOQYqVWjOPqFsn/dfdOYioWCHegl9IDJYsPCvWK73Rs5Bo1dzE5FIxQLFuf5X4OxcLZgOQ95INGlzi3t3WT7Eu3dtdPC3qLxC996kSQ52Kdu8eGB3bHdRDmfIZvzwsBHMa/qoNQepwW3+iReOJRtys/zoQSH3Nxo+IXt3b/ruBxeY/d2Q/sWDJwO05xXISUhUzfX9KYmLFwvxxRHcpsdTjrxM1XeF9PggLq6nz9xKDWYRI8ynCX48lem0Jj1zaOOqF+wP3T9bz3qOkSCyYk5jXeaCcBKtxEwQGLNTiwkCcFCtGiiTX0v9hz+eDoIsnKJ/XyCRYsW5eTAgm4kZyyaQmbUtuIirrF1tYOK+QbO0uor210b8DGe0il4o55UQv/jvvbweKBXMME7Ml9ooLEGFQUUDVKyqMn7SNF9s8fR/R8fPRlmztQ/YfK6R5xGPiIop76FqxAQsNhBqg3B9wk/F8kt6ih3T+0q725yYMNi+lGwWXYAmORwgm7iHfxYNVGuDgOSiLkMHvHe7cZ3EvCPg7XGCO1wvBxD1kuHhI2urFS45exSLIe+cgd54rWG8hmL0Yl4m5L1ioB8YSzR5l3cWz0/3E4kUy2a3QicOEYExkZHIZAsKAIvctXhAsz2bCIx1w8jzRxSuB9MBAC3GjThWIEIxDLuxImWnJZRSuDnBhTKlah4E2HNvhL4kq9xKdOB+7+mJxBdGCuxiu7E1CMDsx0neDuwSHXvlEXTsFrsC41TcQnbsQqE6IJXXHgpMCQqoBK/XstsSNkq/tUV57meixu80LHYhZY5xnIVi6xF+IQUAmvUZAFZHlQ0jcVn6UuELCjTj0hfX3WPdr413IW/YrX3Cp+RIsCEJCMHsw3NcjeaSaMIhoynBrooM/cfvdwJX8zQPhVeQqsDis1PU5AVwY1GqOi8289/hcseC/PGLubz46bv5coLI+RuWJEIyB7OzuzhPLSPuFWYCkqCKfOjxQRa694p78k7tOMuKlVe9o3LzLzPdhWMCqGsVNNFmOVVQoMZhtAoeTcdWSCUSzHJ5MBYsGxXD5tvb8TX0KXUdYVhD88/qAAAF3LtLdwvMcNDEsHz4bx2TGa4gj1QvBTOK/e/OdeWMEyVj0yUrm4nMwf2LRq4EFhfgsWfjt8YBlAamNijDc2DEvl++emiFYnN4w6QczG3854R4mm1xalxGfqy4MLKpkAK4fxATELEaJwz2+OK5bYqvKsHwxrJgQzCDyCwqoz80309CbB2QGubRX3iXjA/ff+4/kfGYJM6d1kuEmljHj2GLG91FSLC5iIoBEg2+5hYYMGUKDBw+mQcrPnj17xY4bPv9TQEY+dMrUMMowLB6fOnKpmDWa6P9WE239mGhciX7CWa2AON8QiIvuHWFejEnQpBj/sxluYrfgIBwzn4eLHuc7iZEM7/AEg2WaNXculZeX023loykvL8/4F4eFhduCce25pgRThsKA9ot7XJLgVVtDMOvvrxTSTB3RvqhBKPzEIo2sgIA1MkswblUGV+hYNEE59k3GX//CXN7nxBiC02EJNvbOO+nRxx6j20bZpNipuaaF46Il8HiYO9o9JwREV3uvkDcymjs69CXR7NGWF6IhcL0EXACgzsbK/0Varmen8UvGVKGjuQMTbMiwW+mZZ5fbR6xYJ3n9EqJ1H+hbM1SJuymxe4mZyD1ez1+IZqc5ceRzFcj/Ia7aWt1+zOo8kJH9Fdd4kD3fB97vVAcl2IIlS+jJp552/oOwAGDN/NYgDsm+47LaP25JEnfRYyE2MciJuJdLBFhpp11yuMwdkWAv/Pyf6L5p05L7oSDZua9juzYDLdYzRiZn1UWOxsiRJpsjUU708i7+sXAWvU6Toi5QwOy2kq7I/+vXHYxgKSGXiuXK5y78RbQ7pNPikJBYbxxQXJ39sV0sxE6wDgjU9WIJlaBI+MZ7LycXPVeqrzpuPuZj/U/neWJMxJiDlBIMCl7fvn1p8NChoefq6urozOnTVPfll7Z8xuNP/K/UkUuNN+4fQ/SaJsDO68SLI0CKZZsTX/nhtkFoQQpgRL/AZ2ml9VilSFbAUffKmELHiXp+HGYGR74IfE9m5fqI1yeNYMgvjbnjDiotLaXevXvHzy+pa+TsWTp4sJpeWfMym2z4zEcefdQFwd+4cCvBXRwbPjLuVuGzXtqVnP+PQzBu7g//F0qtpg53/n8qZuTDIr5bxwgGGXywQqJJkydTSelg4/klNQbu1UuxPDP8t3ff2cEi2qqf/cw9fmqkFWO5R7Xu9MGPM6yKTpNiQmCHFKcJBivfrbPlQTs+J4hla35JAUg2atRo+v7SR+nYf/6n4eNwTIrnANNjrRLMzc2SZotjAVRY/JLxP6Ew+ciXzokdaJXBueZUjkTUS9pWiwh3bNO//Ru9umGjIwsbFq1y4yYaMmyYoddPnzXTXQtQLdlxA1H8+2j1D0yQ+uG0wA33exby35PjJpZYmLOxvsq587PzSDuRL5oUf7ZV22/BYC1Wr11n2g00vUbz8/0kmzNzRkJ3ERbPdUBCU5XscaUz699zXSp1HNvAm+KPG7hHuc0tD+8RMwNOw2aRBUI7ZcV2ftpexYJ4D3Gv0RkdeC26BHJsJNjd90yl1evWJc8QKCRb+eLPaP6Df6NrTWHxuGhqaqJ3d2yn6upqqvnsM6o7fdr//OKi4fTEdxcSLRxvvRgUqp5pghWYJ5jRfYdV4QHbqM5Zy7BgDFKWWSTHynfs7UTARS/SMoIwiMViTZvS5iIRH8fId1oiGBby8y+8kHRDcHt5OS1YvIQ2vPZq7OPq25f93v/6+iZat2YNNV6I7j3yNF4OXN1wIjlfrHZBcfz78aXm6/HM7DuskkxnFLStBMNxcUqmtDEpLK7RC0gicsWrIcW0qV8dDrj46tQug42ilmKwytc3O+4WxsP3Hn3Un0eLBaQBOHj37bdp1fPPxyRX1Be76l3eglLjnEOM1IPZMh/MOuRc3bsxuoC5DZG39bO2EHAhQFe2lWZRiBqJCrTxO1xcTTaKsgk2+/4HLLlhdriKs+bMtfU9X1Esl+kYwCwGFbUvDA5BEUsZdQ1R2c+yDMzFyqlnLC60/sWpiXXET2aJtUz5u8c3OSY8sV3E7y1dmnLNYOLkyXHdRLOora1RYi2ThOGUCKkLilskq0472vJxfCEElmv+XbwTgWPiLjaO0DHQpmnCOGbEZIihYBXvKg1Uz6vn1x8vndfvbXMLwSCVp9J6aWMxxIF2lFVdbGxiXLEZvVDaBcWtDAfJoPj9TnFVGpvbBRA7dkCxMr6NE1eO7GfvovC7cg3mZyG6iWBjxo4lt2DG7Nm0bvXqsOeOHj2anA/nuHnaBXXIgswMIs1yIBWx80hyz8fFK5TJYMVgo8rdk2Mqj3EsZ07XmX6fXkxhxDS6agQEzPJwGz6xMKpadXvNgDsGIJMJlrTFaAAoHo5UExsvNPhzWWYAlzeeKmmvOtMpXCj53EULDCKB1WD/fZNCg5MVGelKMKvx157f7Kbnnl1Oc2fOoKmTJtLfzn/YL5Gz1mt+PvWOkff6w4EDpt/r7nvuMfcHg2zYBOKjE+5ZDXYs9i3VxqwYXvPiv6ffZhTJiMG4ua+zZ8/SonnzotQ6VErs+/3vqamxkR58yPwu8mPGjI0qAj575ozp95k2Yya9uXWr8T94/G7r3wBGpc1xwY6SKPOxY7HjPZCXikzER3Zgo/KhKbPjLzbBuPjRM0/rSuGooLhvxgzTBC69ZXDUc7U1x0wfH1TJWfc/QG9t3ZLgChOcIc9R7CKv7mbr3ZwA+qusVvpHkgzlVrDwuHDgcTpYKqQ4IPEjV4k6STSo7q21FJcmlWD7FSulB8ROJ2pq6LZyc9X4g0qjCbb/449Zx/j8ypWUrxA8Vn4tr49y4h+oIJp6K18OjyWDc/eksgOIAbW7mNgJjqqYbCBniM0HB8TZQhZK7VuK27t6V/IIBgHBqRKpGgbBesfojEZujHucTz79ND2ydKk/+ay6xL169bbnf/48zqJ7RnFNK/82uVN+IWpg2E0HcNVieiEv3G/sogaSId/IsPIskeNiUxPrf0JSOBE4rh2EjljvzRE6tHHmqFHl/lspoyM7LuKVE2GRo9wnGRswwE3Fro+ofOiI5ALg4pvxGNAwy9iInWXBahUrw1ESMfM9UdUF17VD8jvyvQ8eqKaKSZPc86Vqd2yMF7uAZNh8z4mW+EQTqdLRCqn7VJcEe91UNw8z9OEtIH6Kdc6n3GryKh5smN1b6zzBOAodMHr0aPpg507d13BduwcfepgefPhhyles2Rnl+H741FP01rY36JFHl6as4j8K7xnIEak1dRinttCmjSFQ1GrHeDa3QN0BNF7cBOC8wULBvcOFDXGmKlao4otZMAqTmRbsGOu8GE1QY6JUXmmpqfcuHdwudGBa1Rvbd9CUSRPp3R07WNK/I9brVybKkNT58OpGDEabEzNZDudurevfbFBZAxs/Csyn554P1HpCkHKaYFw3rnTwEGMErj1Gg0wSLFZchnaWTZWVLOnfdlRW8aRq7UYMWGAo6o28koJUZnaLTMuYqYLfIaAC8+mxpSw6ETidDIwObBbBuG6cWo6UqKGx6UKjLd9Jr969/Hk3dCnDVUwZkOeyo7o7mdu8JiuGMmJN7CCXCnQioAaU08nAGDXHzoNx8lXAkKHDaP/vfxd6rB1IijmKJTYqdrePDhQCr1292l8UzDleW8hlZxI3XYG4B0N/VDFCHeudaF81K71t8fD9KfwZ90hCJ4NgNUyCPTT/YZoxe6Y/OWxbbikOtPmx5U89Res3b1Y+M4l9bJDCTfrsGQFtRcSIYI+anhiBTTLg+kbu34X34XZl6wHEqme60iPNKYlsgnGFjopJk5P2Pav5Mbi0cBVRB5kUkkG1W7srPSoZ7CTTgGJ9ZS9RfLQlQuUcP9i5xDt3Yq/JXXFMEwwzEDHUM1Z5khuhzY+BZHOmTaNnfvQjum/6dGeIVbnXWk+V22MmkKmkZ2DGIiyBnUXK3xkRbvHnOujSc4/b5K44pgiGnUpcsZmCCWjlewD1js88+Q90oHo/fW/pY9atGRKaaN2vqs0sYkUmce0YR5DQOhSFx2yp3hzeBqHDMMHyCwrTjlxAvNzbW1u3+m93fPvbNG3WbBqkELE0QWrgSv2fqdPJrwNJ2yQOTkkKmdStVJNFpnjxTeh+f/eeLxMz9U0QLD8t186oBHPy0Ye2L1jljxTC0OBeZb369PH/PFtXR6dPn6bGxka6/+pN9IOCOzMrfsKm327ZMVK7d3NPG9ebP094ITBRSrVCJUX8i4iJmfqGCWalOj2lFl0jdCQC8nP79FpqOt+UWeSyc+y0XcDihWdgx7xEdAu8dyS+6764IvZIbBuFDlPV9ChhSkegyFgQubjGuzPGUScfWxFPkFtb/GqgplMvLsZI7DerHRU6TIkcB6urLZcwpQJ9evfJLMsDSby4e/iI64vNihv0tfFyKYsbyzkGO0q9Eo3BDiNZVWAkudnNAw3O7zdFsLNnz6Tlmow1UiBtxAds+GA2x4QrOISY13TqH1M9AyTecasWB8fNiQ3NTsZCvPfGQfOuIlxZuwnGLfK1itraWjpeU+NPbt83Y2ZCtS8SvXr2Ti9SYf48CkutDCXFVRk3jFGLRTSMChhQ5C5ywfKouMRUZ08yxuChNpFDMLtdRM5ATzOAiKISCU2dmNB7BgpeRHFw6VNPm3rf3+ze7X5icVsxEgEkgzu44bfh8+xPuIBgamtNrF61c4389zQL1t5m/ewnGJK0EDrsmEuP9wGJzp6p8//cv29faKM7XWt21FyJFkbFbX9jm7stFtrXZzlctYAq8rzc9no/KzPouQsfUvmRLwLkhiuo58rVJ7HtBsQ2276Ci5OBbgDTpVIHD1b7NyU3CwwWhWWqq6ujaoVMCffgioN9v/8dfXLggG6hsWoJD1RX06bK9ezPSopgkUypfH6wcBYkS9bYbizcZZvN12VyW3O4+z5fajYfl+L7a6q3l2C1x2oUgpk//ldeXmPLLijAY3//9/56QlRfYMSaagkjt3xNCkFQBY4rstmKDjNbu9pNMitNhxzryVEG1Q39zF58BjKmLcMScS5yqDw5bjPBUNnAQayhNFyo9YTJBJLVt427l2j42GhFDwv1zQPR7RZ6xDS7taudQEBfVcNTz7hWhVOniQlcZof/IIY1uy3teKbKbGBvM9ME+3gfT0m80NhI6QKUTI2+4w7/kB5DTaAgitYyJEKqKyhwvEg0r9lFNK4kvtihne+BxQ6SoLTKbA4NBcMcgnHjxCXjjQ8KtdJzZmBvM9ME4wodNZ8dTQtyLf/xc/whObAG2Cxb7+qJ9nc3VFBAXYR8v+AXgcE6dwVTHxgXrSdCcMQHxrAYP04w++kwSer4n+J3SauAcrv8Pv73oa2dtItg/jjM5FzEf3nlFfPbs6YAaMexNIFKLSKNd7XG1XL+Xe75h5HExsLXDtZJ6LYxdvXkCg8nLDSsokt6pOIubq1uj5PUKhj0s91VYk+aIoH7yyLYiz/9qX+jhHhuE1Q8yONQ8na89WbCmfTucAttasfRc4dwxXQTONaIo+7hSm9yWIwloUNrpe8Z7uw5TOD+8qZKKdZo7vTptHTZMr+Sd1GJr7TJ4cithJIlQqjDczDsRp33cfDgAf8Q0kQCyy3DhtpzIHru0Nxy95AL8dVxRtUDd9GbHBYTwm9rzVvMZCKB0MGeyQGSJVvJixQi5i9aTOWjy3VFCPSDYQjpwvkP6xIfYoY9V7Si+O6hHS5JfbDOsD6Y20PyGPGTmQXvn03/Ab+wlqPujTQ/djrgJiZpB1CUWA1kfD8JhA4fpSFArsrN/ydqHEDc0Cg/n55e/izNf/Bv4r7Gtn2n4wW+VnbDVGfKYzJwLFK8tMtYb5M63gC7UFqpWueoewOZ/z9GMTx9n/OLChUmHjJ/EUwgdKQlwZ758Y8Mk0sFYka9oae27jsda5MAbgMh3LHl2xJXQqC3Ce0q6phttYMX1u5EPS8Zbqf4MIDZrIpjPvKl813XqqXkeBk6FR0pJZi66bjZUqZRo3jWJnLoaZiBsbPPLZY7pO3dMgOM3DZaZmRGDUw2wRhTcUPA3tGoenESDg0sShrB9Cb4QnX85EA1bd++PeHuK/4LBrPYeIjyubEINmTYMHv/2aJCe94H1isZhEmW0GFiWEz44j9lTU1MBIzbA/E/YX5HOhdARwimrYTorbhetynxjV4lBH43YdJk/23Pb3bTiytX6qp+3Ir+eI2XffvY3PFcZpM7k6wAP1lCR4kFkQeW3KlYbGfwIgaSmXVH1+5y1oKBTLcoFgBWqVyJcwYpP3v25LezYPIvdmFZ+NC8uCTjVvTHcy1L7VIQ9dwhtPRzxA07oc6H75Xf7hZxlL1kCx2q+3vvCPtjMVgvrZeALXWNFGHDcoFcCc6fj0um0iGD/cqbFTLpuYCVr2+m2dPuixmfcSv64+3uYnRbJUvuECepa6UYWDtuIN58eJQUobMZncRmBRBOu8sAi1O5MMRm/RL7iqTVjfm0gLu36NVAMbZWtlfTIxCOTtQbjtl0CTYUZBo6lEaNLvePyi5N4rhskOHhRYto3erVUb+zMroArmtknGerghjPHeLMqee6VGZaYaCa3T/G/A4w55gXDIPDYuJ+JnrL7GjzUUcUxPo/8NzCX7QPZMVjpgIbc2zbgiVLaN8nh2jL9h204qcr/e5YaQpm0c+bF7su0MrogtGjo91ERyZlRbpD+JLMunxqiZGpKxOjFWYOo8IEC+7z88m7aGgvVCCZlc3i4RYamTyF/xGfZyG9EUUwFLw++dTTrhgwigTxmG9HT9JFRf/xWl7sEGmtbFcQ9dyhI4yCZ2yIYMo17W9ebeNag8MMadvgLIuEJANBdn5qnljLlL97fFPSdgKNchGnzZhBbkI8aZ07ozFylHYiBZE9zTiW0MGJw2BdjG5ezu1t4lqDEymwYFqPwB+TVQUuQiDuQE0TLGIm3FK8V3UYwZCr6mnj3ll2jNrGNrCxwN2fLHKUdiIF0dL2s5FCB6fVAwtm2RSin76j/7q/HhtoheFYo3NMgnGSswaHxZgimot3ELUtD4bc1MEDB/wLHyKEOm4Nqt2ChYvo75byFmlenE0nULXPhXZ8QSIFsXr/fnrwoYd5F4rIqzV3kAtaLnCFxlarJ4IxQV6w9wwq4ZTh1oL+zy2IDpy5Ht06ZcauNGYJxt3g4Q8KseIV0oJkL7+0mnoqrhhn07t4G6KjMp5rIbV1jIkURPSycfejjoo3rPQ3qVutOoGqWgvkZGwmfrFjkCumyAGymHe7Ei/yd956i3WA2As6bgig8zt9ggWsFpos9eK42tqahMeQkBSR+G2tu1aAdlw1BydNWj8IDU0dmGAHD5jfbaK3gWQz5hnC4phFtc6QHe7CV0dvJ2qyPHfmTFBQYW5kruZ9wqzFcXetgPc+tfb3W0ysF1iuVe9QR0IUwcxOzlWFAyNyt9ntjzCsVG+Wh1Who3eCXVdqgwS2Eu9FNeQhDvvcJTWGsF6/slhMjDhs3a8TEwuWCxUS5xo6FMGiRI7PPvuMJxyMGZtwVICZeAkzPV5Zs0Y/PrJQ0QGhI1FPGQQOK7GpH7G6ZLdVJ6eJMBEqq+xZ8BiRgBTEnDFExQUBQqkjsnE7Xk8dFb5oUYI3li3RFkFmUgAg16J58xJOorKy8EGuwUP0j1lbMYLYtGLSJOsWDEBx6cIUb4CHJK2drTAoet1bS4IELqI/5jhoPg7Ta4Ice+ed/uJdI0C7yj++sIp639w31JCpB67QgcE4JTrlXxjkoyU4JzYNCR15MWTsVe+m7luHi/ryLln9qbBg/tiDUa0O6wQrBVm+b9++VA4XjFFxj3YV3ELHUltD/7rpdXpz65a4QgdHQocw003H8tVGlGJxYtMQYs3OQyyGLYUWJHlOImKh5Vs7lJLnPoIxF9PO3b+x/QBRZLxi5Ur63tKlMXvEoPBxhoVC6NAXOI7ZEpsGCBZndh7maADJItmGj1xd9dBhXERLi8khqD1isJJaWFL4dBCZAlBjUxb0xoGBZLBkTlstbAou5HIHwSwtpiSQTBubqUKH3TgTYxcZTmwaV+iIJNkP37DWghEVRF4Jrx7vwEqe6whmaTElgWRoxNSCU32SCMdiWHHEprYKHVrsVd57zlqiF9/lEw3V41AH8R73rwsQy6FpSQILMRhX6IgHdVb9H5R4CT8hq2Mz817Myn00Ym5a375zJRQ+loQeV+CoiTmq4FqthY39jO6RpY5eQ18X/gb1jMXBdn81x4T5Hv6thc63t7DbOfdQ4DzBrCRxIyvrYyWg165ezd4qCALFrDlzacNrr/ofczcFjHv8wRKpSHQ6fs5+oSMeoDLitmW/rNJMJBi3Wh15rMceecTQa9etWaNYshmsRDHmhKgE424KGNeCxcmteRov86vh6xtktUkMFm2JnATEFG6iWNuZbLcoc+yYTpriECOm8Q+nPC+rTQgWIXRUmxc6zI5A41bEqwW7TogyZ/RcTk71ORolz4kFE4JFuUrmE85qRYdxAYS/d3OeJlnMVvgigBIp3aJlxEVGhteoih5k8kRbmQo6XgxmRegYfMstCTe841o8LfK1BLNSyqS9qBiZVvXYpsB2QffeGojHnNzJRJC5BONWq2P2oJFNHFAEbEVe17pydlWfGLbaSA6rpU4CAcdFBDgihJ5VQhUGiPXCz/+RXt2wkX3gyKdpraQdQgfec1PlBlkVguRYMFWEMFutjpZ8tbLeqVn2sao3Pty9m5VXU8m1bOnShD1oAoGtBOMIHVD4tu1429HpwLG6nTdVVhrOqxlJhgsEjhOMK3Q4SS4MA41lafDc3OnTaf3mzWFlWFoyHTt61F9naHZXTYHAEYJZmkfhAFBlser55+Mfr0KyKRPGh4bwqANQBQJXihzx4p1UAMexcN7/NPRauHy4CbkErrZgfgEgTvFrsgAL+i+vvEIbg7WHAkFGEYzblm8FatyEz/71+++LJRKkLcFQJOff5c3j9VBba1vUi+yuVo9HJhEhBGkPz3Xtowafx+NpaGtr8xPM6/VRS+u1qL/hzkqM5+4hlqo5doxqFEJV79snZBJkENoJpvCqwfD2Re/s2G56nyyQ6XhNjd8yQf3br5Cp7vRp+Q4EEoNFYuP6St02f+1YACGTQGCSYHATMc566bJlNCg40121TlIJIRDEIRj8xFB85vHovhhJ3Gee/Ac5awJBHFzwtLcpKXw6hURzO8G8XjlDAoGNCCOY1+uRMyIQ2EkwyPQhC5YlFkwgsIIz1O4iKuHXKa82BvN6suQMCQQW0KRJNMN4SQwmENiIRgqv5ICLGBr0l+XzyRkSCCygznM53EVsbW1tEIIJBPbgS09z6L7X6z3lzc7ODg3ty8qSGEwgsILTdFn78IJ3165dp7QWzCNSvUDAg+c6/VGTaN69e/dhVdUIWbHsnFw5UQIBAxc8F7UP/ZzyE8zj8YQI5svOkTMlEDBQoyFYW1tbO8EUhDbvze3SRc6UQMDATu9X2od7QgTLysra027BsiUOEwgY8VeV5+vQw5aWlr0hggWFjgDjvF6xYgKBSRwNt16Hq6qqTmldxJBJAzp3zZMzJhCYwDZvfbsx83g2qPdDBLt+/XpoFnVObi7ldOokZ00gMOQeXglzD69du/Z2FMEUk4bhNyHmdS0olBMnEBjACl/7DkTgkOoeRrqICMxWiBUTCEzEXln1keLGCu3vwwgWZN5L6uP8G24URVEg0HEN/8n7x7jWK4pgwVgMDPQXAKM2sVtBdzmRAkEMVGb9MVQahcr5SOsVk2DBWGyh+rhLXp5yy5ezKRBosD+rjjZrlEMFP4m0XjEJBnz44Yc7tK5iXvfu5MuREiqBAGj1XKTlWSe0T72kcCbmfshxW5iDrmKoRrH7TUXkzc6Wsyvo8HHX3/n+Qxt3nQpyhUwRDK6i8ocz8Qb+F3q91ENIJujg5FriOxQZd00EV0wTLEiyUwqxZpJG9ADJxF0UdES3cLbvoLbfqyFIrlN6f5dwyg2axjwez0QtyW4o7inCh6BDCRp3Zx+gBk9o56EGcCIRuQwRTCWZ4i6OVN1FAMIH8mTiMgoy1yW8Tm9knQwTNMABkAucMPIWhue0ga0wiVqSde7a1e8ydu4mxcGCzMIFb4MSbx2gf84K2yHoMDhglFymCKYh2UjSSPhwGfN79KDuRcVizQQZQawV2YdplkbMCOIlxYsz5BaGGUHugVRUVCxQTOVzyq2/9vmrzc105dIlunz5ElFLa0ad/CWdS+gHBXfKKsxAV/Co5yvaFlFXqMZbKLwI5obNv7WV4xo/fnx/xYKBZAti/R5ka758ma5fbaar166mPeGEYJlDKAyoOabc3vd+RZ/SRa2AEWm1VujJ8I4SzCjRVLRcv45q48BP5aZcGaitFfdbQq+53tIS9jetrS2uIaYQzH1EURZH2FNtdM0/vhoz4vGzUfnZpPys8zRTHV2mLzyXI12/KKBoF3WFZt1BxwimJVp2dvZ05QBBtDJZAYI0wh7c0HhsxWI5SrBIsnm93grFqk1QbmVCOIHLcBij1TDwSSHVHgVfOGJkk/kfTZ48GSQrgDDS2toKcaRQ+ScLtUJJpGiC3+N1sh4EMdCg3d8uuF7wuCEoTqi/b8CceOzDoNwOO0WmWPj/AgwAm7AE4lyAnRMAAAAASUVORK5CYII=';
        } else {
            return $app->storage->name($this->data->image)->get();
        }
    }

    public function searchPoints($query="", $delivery_id=0){
        global $app;

        if(_mb_strlen($query) < 2){
            return [];
        }

        $result = [];

        if($delivery_id){
            $data = $app->model->delivery_points->sort("address asc")->search($query)->getAll("delivery_id=?",[$delivery_id]);
        }else{
            $data = $app->model->delivery_points->sort("address asc")->search($query)->getAll();
        }

        if($data){

            foreach ($data as $value) {

                $result[] = ["id"=>$value["id"], "delivery_id"=>$value["delivery_id"]?:0, "address"=>$value["address"], "latitude"=>$value["latitude"]?:0, "longitude"=>$value["longitude"]?:0, "code_point"=>$value["code"]];

            }

        }

        return $result;

    }

    public function getPoints(){
        global $app;

        if (!$app->model->delivery_points->count("delivery_id=?", [$this->data->id])) {
            $apiUrl = 'https://api.dostavista.ru/get-pickup-points';
            $apiKey = $this->data->params->key;

            $response = _file_get_contents($apiUrl . '?api_key=' . $apiKey);
            $points = _json_decode($response);

            if ($points && isset($points['points'])) {
                foreach ($points['points'] as $point) {
                    $app->model->delivery_points->insert([
                        "code" => $point['id'],
                        "address" => $point['address'],
                        "latitude" => $point['latitude'],
                        "longitude" => $point['longitude'],
                        "workshedule" => $point['schedule'],
                        "text" => $point['description'],
                        "city_code" => $point['city_id'],
                        "delivery_id" => $this->data->id
                    ]);
                }
            }
        }
    }

    public function createOrder($params = []){
        global $app;

        $orderData = [
            "order_id" => $params->data->order_id,
            "customer_name" => $params->data->delivery_data["recipient"]["surname"] . ' ' . 
                              $params->data->delivery_data["recipient"]["name"] . ' ' . 
                              $params->data->delivery_data["recipient"]["patronymic"],
            "customer_phone" => $params->data->delivery_data["recipient"]["phone"],
            "customer_email" => $params->data->delivery_data["recipient"]["email"],
            "pickup_point_id" => $params->data->delivery_point->code,
            "dropoff_point_id" => $params->data->user_shipping_point->code,
            "total_amount" => $params->data->amount,
            "items" => [
                [
                    "title" => $params->ad->title,
                    "price" => $params->data->item->amount,
                    "quantity" => $params->data->item->count
                ]
            ],
            "weight" => $params->ad->category->delivery_size_weight
        ];

        $apiUrl = 'https://api.dostavista.ru/create-order';
        $apiKey = $this->data->params->key;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = _json_decode($response);

        if ($httpCode === 200 && $result && !isset($result['error'])) {
            return [
                "status" => true,
                "id" => $result['order_id'],
                "track_number" => $result['tracking_code'],
                "label" => $result['label_url'],
                "shipping_point_id" => $params->data->user_shipping_point->id
            ];
        } else {
            $error = $result['error'] ?? 'Unknown error';
            logger("Delivery " . $this->alias . " createOrder error: " . $error);
            return ["status" => false];
        }
    }

    public function fieldsForm($params = []){
        global $app;

        return '
        <form class="integrationDeliveryForm">
            <h3>' . $this->data->name . '</h3>
            <div class="row">
                <div class="col-12">
                    <label class="switch">
                      <input type="checkbox" name="status" value="1" class="switch-input" ' . ($this->data->status ? 'checked=""' : '') . '>
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">' . translate("tr_87a4286b7b9bf700423b9277ab24c5f1") . '</span>
                    </label>
                </div>
                <div class="col-12 mt-3">
                  <label class="form-label mb-2">' . translate("tr_55c9488fbbf51f974a38acd8ccb87ee1") . '</label>
                  ' . $app->ui->managerFiles(["filename" => $this->data->image, "type" => "images", "path" => "images"]) . '
                </div>
                <div class="col-12 mt-3">
                  <label class="form-label mb-2">' . translate("tr_602680ed8916dcc039882172ef089256") . '</label>
                  <input type="text" name="name" class="form-control" value="' . $this->data->name . '" />
                </div>
                <div class="col-12 mt-3">
                  <label class="form-label mb-2">API Key</label>
                  <input type="text" name="params[key]" class="form-control" value="' . $this->data->params->key . '" />
                </div>
                <div class="col-12 mt-3">
                  <label class="form-label mb-2">' . translate("tr_5bf2cff001d36b038eabc3ae7660fcd9") . '</label>
                  <input type="number" name="available_price_min" class="form-control" value="' . $this->data->available_price_min . '" />
                </div>
                <div class="col-12 mt-3">
                  <label class="form-label mb-2">' . translate("tr_bf939ddd3c5df260fce70c996785c7d6") . '</label>
                  <input type="number" name="available_price_max" class="form-control" value="' . $this->data->available_price_max . '" />
                </div>
                <div class="col-12 mt-3">
                  <label class="form-label mb-2">' . translate("tr_ab223d16e2cfcd7e59cd23af7ae6bc88") . '</label>
                  <input type="number" name="min_weight" class="form-control" value="' . $this->data->min_weight . '" />
                </div>
                <div class="col-12 mt-3">
                  <label class="form-label mb-2">' . translate("tr_e82192b8980d7924578688c149661978") . '</label>
                  <input type="number" name="max_weight" class="form-control" value="' . $this->data->max_weight . '" />
                </div>
                <input type="hidden" name="id" value="' . $this->data->id . '" />
                <div class="mt-4 d-grid col-lg-6 mx-auto">
                  <button class="btn btn-primary buttonIntegrationDeliverySave">' . translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") . '</button>
                </div>
            </div>
        </form>
        ';
    }
}